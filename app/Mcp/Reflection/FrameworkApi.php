<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Reflection;

use Composer\InstalledVersions;

/**
 * Reflection over the `Quiote\*` framework namespace: reflection-generated
 * signatures + docblocks for key classes/attributes, so it never drifts
 * from the code.
 *
 * Deliberately scoped to the `Quiote\` namespace -- this is a reference for
 * the *framework* the agent is building against, not a general-purpose PHP
 * reflection oracle over the whole vendor tree (this app's own classes, or
 * third-party packages like `mcp/sdk`, are out of scope for `describe_symbol`
 * / `list_api`).
 *
 * The framework is a monorepo split across several `quioteframework/*`
 * Composer packages (`quioteframework/quiote` for the kernel, plus optional
 * ones like `quioteframework/mcp`, `quioteframework/csrf`, …) that each
 * declare their own PSR-4 slice of the *same* `Quiote\` namespace tree (e.g.
 * `Quiote\Mcp\` → `quioteframework/mcp`'s own `src/`). So the class list is
 * derived from **Composer's own PSR-4 prefix map**
 * (`ClassLoader::getPrefixesPsr4()`), not a single package's directory --
 * that map already knows about every installed package's contribution to
 * `Quiote\*`, however many packages that ends up being, without this class
 * hardcoding any of their names. Reading it (rather than
 * `get_declared_classes()`) also means a symbol can be reported before it's
 * autoloaded, without eagerly loading the entire framework.
 */
final class FrameworkApi
{
    private const ROOT_NAMESPACE = 'Quiote';

    /** @var array<string, list<string>>|null prefix => base dirs, longest prefix first */
    private ?array $roots = null;

    public function version(): string
    {
        return InstalledVersions::getPrettyVersion('quioteframework/quiote') ?? 'unknown';
    }

    /**
     * @return list<string> every FQCN under `Quiote\`, optionally narrowed to
     *     one namespace (and its sub-namespaces), across every contributing package
     */
    public function classesUnder(?string $namespace = null): array
    {
        $prefix = $namespace !== null ? rtrim(ltrim($namespace, '\\'), '\\') : null;

        $fqcns = [];
        foreach ($this->roots() as $rootPrefix => $dirs) {
            // A root can be skipped only when $namespace and the root's own
            // prefix share no ancestry at all in either direction -- e.g.
            // listing "Quiote\Mcp" must still scan the "Quiote\Mcp\" root
            // (a *more specific* prefix than the filter), and listing
            // "Quiote" must still scan every root (each is more specific
            // than the filter).
            if ($prefix !== null && !str_starts_with($rootPrefix, $prefix . '\\') && $rootPrefix !== $prefix . '\\'
                && !str_starts_with($prefix . '\\', $rootPrefix)) {
                continue;
            }

            foreach ($dirs as $dir) {
                if (!is_dir($dir)) {
                    continue;
                }

                $it = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir, \FilesystemIterator::SKIP_DOTS));
                foreach ($it as $file) {
                    /** @var \SplFileInfo $file */
                    if (!$file->isFile() || strtolower($file->getExtension()) !== 'php') {
                        continue;
                    }

                    $relative = substr($file->getPathname(), strlen($dir) + 1);
                    $fqcn = $rootPrefix . str_replace('/', '\\', substr($relative, 0, -4));

                    if ($prefix !== null && $fqcn !== $prefix && !str_starts_with($fqcn, $prefix . '\\')) {
                        continue;
                    }

                    $fqcns[] = $fqcn;
                }
            }
        }

        $fqcns = array_values(array_unique($fqcns));
        sort($fqcns);

        return $fqcns;
    }

    /**
     * Immediate sub-namespaces of `Quiote\`, across every contributing package (a browsable starting point for `list_api()` with no argument).
     *
     * @return array<string, int>
     */
    public function topLevelNamespaces(): array
    {
        $namespaces = [];
        foreach ($this->classesUnder() as $fqcn) {
            $segments = explode('\\', $fqcn);
            if (count($segments) < 2) {
                continue;
            }
            $ns = self::ROOT_NAMESPACE . '\\' . $segments[1];
            $namespaces[$ns] = ($namespaces[$ns] ?? 0) + 1;
        }
        ksort($namespaces);

        return $namespaces;
    }

    /**
     * Every installed package's PSR-4 mapping for the `Quiote\` tree,
     * keyed by prefix (e.g. `Quiote\Mcp\`), longest prefix first so a more
     * specific root is matched before the generic `Quiote\` one when
     * resolving a file's FQCN.
     *
     * @return array<string, list<string>>
     */
    private function roots(): array
    {
        if ($this->roots !== null) {
            return $this->roots;
        }

        $loader = $this->composerLoader();
        $prefixes = $loader?->getPrefixesPsr4() ?? [];

        $roots = [];
        foreach ($prefixes as $prefix => $dirs) {
            if ($prefix === self::ROOT_NAMESPACE . '\\' || str_starts_with($prefix, self::ROOT_NAMESPACE . '\\')) {
                $roots[$prefix] = array_map(static fn (string $d) => rtrim($d, '/'), $dirs);
            }
        }

        uksort($roots, static fn (string $a, string $b) => strlen($b) <=> strlen($a));

        return $this->roots = $roots;
    }

    private function composerLoader(): ?\Composer\Autoload\ClassLoader
    {
        foreach (spl_autoload_functions() ?: [] as $fn) {
            if (\is_array($fn) && $fn[0] instanceof \Composer\Autoload\ClassLoader) {
                return $fn[0];
            }
        }

        return null;
    }

    public function isFrameworkSymbol(string $fqcn): bool
    {
        $fqcn = ltrim($fqcn, '\\');
        return $fqcn === self::ROOT_NAMESPACE || str_starts_with($fqcn, self::ROOT_NAMESPACE . '\\');
    }

    /**
     * Some framework source files sit behind an *optional* dependency (e.g.
     * PHPUnit test-case base classes, the OpenTelemetry samplers) that this
     * app doesn't require. Autoloading such a file when that dependency isn't
     * installed throws a catchable `Error` from inside `class_exists()`
     * itself -- treat that as "not usable here" rather than letting it
     * propagate and failing the whole listing/describe call.
     *
     * @phpstan-assert-if-true class-string $fqcn
     */
    public function classLikeExists(string $fqcn): bool
    {
        try {
            return class_exists($fqcn) || interface_exists($fqcn) || trait_exists($fqcn) || enum_exists($fqcn);
        } catch (\Throwable) {
            return false;
        }
    }

    /** @return array{fqcn: string, kind: string, summary: string} */
    public function summarize(string $fqcn): array
    {
        if (!$this->classLikeExists($fqcn)) {
            throw new \InvalidArgumentException(sprintf('Unknown class/interface/trait/enum "%s".', $fqcn));
        }

        $ref = new \ReflectionClass($fqcn);

        return [
            'fqcn' => $ref->getName(),
            'kind' => $this->kindOf($ref),
            'summary' => $this->docSummary($ref->getDocComment() ?: null),
        ];
    }

    /**
     * Full class-level description: kind, hierarchy, attributes, and every
     * method/property *declared on this class itself* (inherited members are
     * omitted -- reflecting `Action` shouldn't dump every method from every
     * ancestor).
     *
     * @return array<string, mixed>
     */
    public function describeClass(string $fqcn): array
    {
        if (!$this->classLikeExists($fqcn)) {
            throw new \InvalidArgumentException(sprintf('Unknown class/interface/trait/enum "%s".', $fqcn));
        }

        $ref = new \ReflectionClass($fqcn);

        $methods = [];
        foreach ($ref->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
            if ($method->getDeclaringClass()->getName() === $ref->getName()) {
                $methods[] = $this->describeMethod($method);
            }
        }

        $properties = [];
        foreach ($ref->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            if ($property->getDeclaringClass()->getName() === $ref->getName()) {
                $properties[] = $this->describeProperty($property);
            }
        }

        return [
            'fqcn' => $ref->getName(),
            'kind' => $this->kindOf($ref),
            'summary' => $this->docSummary($ref->getDocComment() ?: null),
            'abstract' => $ref->isAbstract(),
            'final' => $ref->isFinal(),
            'parent' => $ref->getParentClass() ? $ref->getParentClass()->getName() : null,
            'interfaces' => $ref->getInterfaceNames(),
            'attributes' => $this->describeAttributes($ref->getAttributes()),
            'constructor' => $ref->getConstructor() ? $this->describeMethod($ref->getConstructor()) : null,
            'methods' => $methods,
            'properties' => $properties,
        ];
    }

    /** @return array<string, mixed> */
    public function describeMethod(\ReflectionMethod $method): array
    {
        $params = [];
        foreach ($method->getParameters() as $param) {
            $params[] = $this->describeParameter($param);
        }

        return [
            'name' => $method->getName(),
            'static' => $method->isStatic(),
            'abstract' => $method->isAbstract(),
            'returnType' => $this->typeToString($method->getReturnType()),
            'parameters' => $params,
            'summary' => $this->docSummary($method->getDocComment() ?: null),
            'attributes' => $this->describeAttributes($method->getAttributes()),
        ];
    }

    /** @return array<string, mixed> */
    private function describeParameter(\ReflectionParameter $param): array
    {
        $default = null;
        $hasDefault = $param->isDefaultValueAvailable();
        if ($hasDefault) {
            try {
                $default = $param->getDefaultValue();
            } catch (\Throwable) {
                $hasDefault = false;
            }
        }

        return [
            'name' => $param->getName(),
            'type' => $this->typeToString($param->getType()),
            'nullable' => $param->allowsNull(),
            'variadic' => $param->isVariadic(),
            'hasDefault' => $hasDefault,
            'default' => $hasDefault ? $default : null,
        ];
    }

    /** @return array<string, mixed> */
    private function describeProperty(\ReflectionProperty $property): array
    {
        return [
            'name' => $property->getName(),
            'type' => $this->typeToString($property->getType()),
            'static' => $property->isStatic(),
            'readonly' => $property->isReadOnly(),
            'summary' => $this->docSummary($property->getDocComment() ?: null),
        ];
    }

    /**
     * @param list<\ReflectionAttribute<object>> $attributes
     * @return list<array{name: string, arguments: array<int|string, mixed>}>
     */
    private function describeAttributes(array $attributes): array
    {
        return array_map(
            static fn (\ReflectionAttribute $a) => ['name' => $a->getName(), 'arguments' => $a->getArguments()],
            $attributes,
        );
    }

    private function typeToString(?\ReflectionType $type): ?string
    {
        return $type !== null ? (string) $type : null;
    }

    /** @param \ReflectionClass<object> $ref */
    private function kindOf(\ReflectionClass $ref): string
    {
        return match (true) {
            $ref->isInterface() => 'interface',
            $ref->isTrait() => 'trait',
            $ref->isEnum() => 'enum',
            default => 'class',
        };
    }

    /**
     * First paragraph of a docblock (up to the first blank line or `@tag`),
     * with the `/** ... *\/` / `* ` decoration stripped -- enough context to
     * be useful without dumping the whole comment.
     */
    private function docSummary(?string $docComment): string
    {
        if ($docComment === null) {
            return '';
        }

        $lines = preg_split('/\r?\n/', $docComment) ?: [];
        $text = [];
        foreach ($lines as $line) {
            $line = trim($line);
            $line = preg_replace('#^/?\*+/?#', '', $line) ?? $line;
            $line = trim($line);

            if ($line === '' && $text !== []) {
                break;
            }
            if (str_starts_with($line, '@')) {
                break;
            }
            if ($line !== '') {
                $text[] = $line;
            }
        }

        return implode(' ', $text);
    }
}
