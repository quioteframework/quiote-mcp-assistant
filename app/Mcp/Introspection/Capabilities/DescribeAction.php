<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Introspection\Capabilities;

use Quiote\Config\Config;
use Quiote\Context;
use Quiote\Mcp\Compiler\ValidatorSchemaMapper;
use Quiote\Validator\Compiler\ValidatorCompiler;
use Quiote\Validator\Compiler\ValidatorSource;

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
     *     _source: string,
     *     module: string,
     *     action: string,
     *     class: class-string,
     *     verbs: array<string, array{schema: array<string, mixed>|null}>,
     *     isSecure: bool,
     *     credentials: ?string,
     *     isSimple: bool,
     *     defaultViewName: ?string,
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

        $verbs = [];
        foreach (self::VERB_TOKENS as $token) {
            if (method_exists($instance, 'execute' . ucfirst($token))) {
                $verbs[$token] = ['schema' => self::schemaFor($module, $action, $token)];
            }
        }
        if ($verbs === [] && method_exists($instance, 'execute')) {
            $verbs['*'] = ['schema' => null];
        }

        return [
            '_source' => 'target-app-untrusted',
            'module' => $module,
            'action' => $action,
            'class' => $instance::class,
            'verbs' => $verbs,
            'isSecure' => (bool) self::safeCall($instance, 'isSecure', false),
            'credentials' => self::sanitizeString(self::safeCall($instance, 'getCredentials', null)),
            'isSimple' => (bool) self::safeCall($instance, 'isSimple', false),
            'defaultViewName' => self::sanitizeString(self::safeCall($instance, 'getDefaultViewName', null)),
        ];
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
