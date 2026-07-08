<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Introspection\Capabilities;

use Quiote\Config\Config;
use Quiote\Context;
use Quiote\Mcp\Compiler\ValidatorSchemaMapper;
use Quiote\Routing\Compiler\ModuleActionEntry;
use Quiote\Routing\Compiler\TriadViewResolver;
use Quiote\Validator\Compiler\ValidatorCompiler;
use Quiote\Validator\Compiler\ValidatorSource;
use ReflectionClass;

/**
 * `describe_action("Module.Action")` -- verbs (detected the same way
 * `Quiote\Execution\ActionResolver` dispatches: does an `execute{Verb}`
 * method exist), each verb's validator-derived JSON Schema (reusing
 * {@see ValidatorSchemaMapper}, the exact mapper the actions-as-tools bridge
 * uses), required credentials, and the default view name.
 *
 * Deliberately does *not* require the action to carry `#[Route]` (unlike
 * `Quiote\Mcp\Compiler\ActionToolScanner`, which needs one to derive an HTTP
 * method) -- it resolves the action directly via `Controller::createActionInstance()`,
 * so a programmatically-routed action (this app's own Index/About/Boom) is
 * describable too, not just attribute-routed ones.
 */
final class DescribeAction
{
    private const VERB_TOKENS = ['read', 'write', 'update', 'remove'];

    /**
     * @return array{
     *     _schema_version: int,
     *     _source: string,
     *     module: string,
     *     action: string,
     *     class: class-string,
     *     file: ?string,
     *     verbs: array<string, array{schema: array<string, mixed>|null, line: ?int}>,
     *     isSecure: bool,
     *     credentials: ?string,
     *     isSimple: bool,
     *     defaultViewName: ?string,
     *     viewFile: ?string,
     *     templateFile: ?string,
     * }
     */
    public static function run(string $contextName, string $module, string $action): array
    {
        if ($module === '' || $action === '') {
            throw new \InvalidArgumentException('Both "module" and "action" are required.');
        }

        $controller = Context::getInstance($contextName)->getController();

        try {
            $instance = $controller->createActionInstance($module, $action);
        } catch (\Throwable $e) {
            throw new \RuntimeException(sprintf('Could not instantiate action "%s.%s": %s', $module, $action, $e->getMessage()));
        }

        $reflection = self::reflectionFor($instance::class);
        $file = $reflection->getFileName();

        $verbs = [];
        foreach (self::VERB_TOKENS as $token) {
            $method = 'execute' . ucfirst($token);
            if ($reflection->hasMethod($method)) {
                $startLine = $reflection->getMethod($method)->getStartLine();
                $verbs[$token] = ['schema' => self::schemaFor($module, $action, $token), 'line' => $startLine !== false ? $startLine : null];
            }
        }
        if ($verbs === [] && $reflection->hasMethod('execute')) {
            $startLine = $reflection->getMethod('execute')->getStartLine();
            $verbs['*'] = ['schema' => null, 'line' => $startLine !== false ? $startLine : null];
        }

        [$viewFile, $templateFile] = self::locateViewAndTemplate($module, $action, $reflection);

        return [
            '_schema_version' => 1,
            '_source' => 'target-app-untrusted',
            'module' => $module,
            'action' => $action,
            'class' => $instance::class,
            'file' => $file !== false ? $file : null,
            'verbs' => $verbs,
            'isSecure' => (bool) self::safeCall($instance, 'isSecure', false),
            'credentials' => self::sanitizeString(self::safeCall($instance, 'getCredentials', null)),
            'isSimple' => (bool) self::safeCall($instance, 'isSimple', false),
            'defaultViewName' => self::sanitizeString(self::safeCall($instance, 'getDefaultViewName', null)),
            'viewFile' => $viewFile,
            'templateFile' => $templateFile,
        ];
    }

    /**
     * A plain `string` parameter (not `class-string<T>`) so the resulting
     * ReflectionClass's inferred template type is the widest one,
     * `ReflectionClass<object>` -- matching `TriadViewResolver`'s declared
     * parameter type. Reflecting `$instance` directly would instead infer
     * the narrower `ReflectionClass<Action>`, which PHPStan then refuses to
     * pass where `ReflectionClass<object>` is expected (the native
     * ReflectionClass template parameter is invariant, not covariant).
     * Mirrors `ModuleActionEntry::$fqcn` (a plain string) in
     * `AppIntrospectionCompiler`, which has the same need.
     * @param class-string $className
     * @return ReflectionClass<object>
     */
    private static function reflectionFor(string $className): ReflectionClass
    {
        return new ReflectionClass($className);
    }

    /**
     * Reuses `Quiote\Routing\Compiler\TriadViewResolver` -- the exact triad
     * resolution logic `AppIntrospectionCompiler` computes for the
     * `overview`/`routes:compile` artifact -- rather than reimplementing the
     * `{Action}{ViewName}View`/`{ViewName}.php` naming convention here.
     * @param ReflectionClass<object> $reflection
     * @return array{0: ?string, 1: ?string}
     */
    private static function locateViewAndTemplate(string $module, string $action, ReflectionClass $reflection): array
    {
        $resolver = new TriadViewResolver();
        $viewToken = $resolver->resolveViewToken($reflection);
        if ($viewToken === null) {
            return [null, null];
        }

        $file = $reflection->getFileName();
        $entry = new ModuleActionEntry(
            $module,
            $action,
            $file !== false ? $file : '',
            $reflection->getName(),
            Config::getString('core.module_dir'),
        );

        $namespacePrefix = Config::getString('core.namespace_prefix', 'App');
        $canonical = $resolver->canonicalViewToken($entry, $viewToken);
        $viewFile = $resolver->resolveExistingViewFile($entry, $canonical, $namespacePrefix);

        $templateFile = $resolver->templateFileFor($entry, $canonical);
        $templateFile = is_file($templateFile) ? $templateFile : null;

        return [$viewFile, $templateFile];
    }

    /**
     * Strip control characters so free-form app strings cannot carry
     * injection payloads. A non-scalar return value (the app method's return
     * type is whatever the target app wrote, not something this tool
     * controls) can't be stringified meaningfully -- and casting an array
     * would fatal -- so it's reported as absent rather than guessed at.
     */
    private static function sanitizeString(mixed $value): ?string
    {
        if (!is_scalar($value)) {
            return null;
        }
        return preg_replace('/[\x00-\x1F\x7F]/u', '', (string) $value) ?? '';
    }

    private static function safeCall(object $action, string $method, mixed $default): mixed
    {
        if (!method_exists($action, $method)) {
            return $default;
        }
        try {
            return $action->$method();
        } catch (\Throwable) {
            return $default;
        }
    }

    /**
     * Resolves `{module}/Validate/{action}.xml` (the same convention
     * `ActionToolScanner::deriveInputSchema()` uses) and maps it for one
     * verb token. Returns null -- not an error -- when the action validates
     * via a hand-written fluent builder (no XML source, hence no IR to map)
     * or has no validators at all; the caller shouldn't treat that as a
     * failure to introspect.
     *
     * @return array<string, mixed>|null
     */
    private static function schemaFor(string $module, string $action, string $methodToken): ?array
    {
        $moduleDir = Config::getString('core.module_dir');
        if ($moduleDir === '') {
            return null;
        }

        $xmlPath = rtrim($moduleDir, '/') . '/' . $module . '/Validate/' . str_replace('.', '/', $action) . '.xml';
        if (!is_file($xmlPath)) {
            return null;
        }

        try {
            [$plan] = (new ValidatorCompiler())->parse(new ValidatorSource($xmlPath));

            return (new ValidatorSchemaMapper())->toInputSchema($plan, $methodToken);
        } catch (\Throwable) {
            return null;
        }
    }
}
