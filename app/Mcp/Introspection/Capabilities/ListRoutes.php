<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Introspection\Capabilities;

use Quiote\Context;
use Quiote\Introspection\AppIntrospectionCompiler;

/**
 * `list_routes` -- every route the target app's bootstrapped Routing
 * instance actually resolves with, via its live `RouteCollection`
 * ({@see \Quiote\Routing\Routing::getRouteCollection()}) rather than
 * re-scanning `#[Route]` attributes: a Routing subclass may declare routes
 * *programmatically* (see `Quiote\Routing\AttributeRoutes::mergeInto()`),
 * and this app's own `AppRouting` does exactly that for its Index/About/Boom
 * routes alongside one `#[Route]`-attributed action -- an attribute-only
 * scan would silently miss the former. The RouteCollection is the same one
 * every real HTTP request is matched against, so it's authoritative
 * regardless of declaration style.
 *
 * `file`/`line` per route and the top-level `diagnostics` array reuse
 * `Quiote\Introspection\AppIntrospectionCompiler` -- the same compiler
 * `routes:compile`/`overview` use -- rather than re-deriving action-class
 * resolution here.
 */
final class ListRoutes
{
    /**
     * `module`/`action` filter server-side (case-insensitive exact match
     * against each route's `_module`/`_action` defaults) rather than
     * dumping every route and leaving the caller to filter -- a real app
     * can have hundreds of routes, and shipping all of them just to answer
     * "what does the Library module expose" wastes the caller's whole
     * context on routes it's about to discard anyway.
     *
     * @return array{
     *     _schema_version: int,
     *     context: string,
     *     module_filter: ?string,
     *     action_filter: ?string,
     *     count: int,
     *     routes: list<array{name: string, path: string, methods: list<string>, defaults: array<string, mixed>, requirements: array<string, mixed>, file: ?string, line: ?int}>,
     *     diagnostics: list<array{severity: string, code: string, message: string, file: string, line: ?int, column: ?int, endLine: ?int, endColumn: ?int, symbol: ?string}>,
     * }
     */
    public static function run(string $contextName, ?string $module = null, ?string $action = null): array
    {
        $routing = Context::getInstance($contextName)->getRouting();
        $collection = $routing->getRouteCollection();

        $artifact = (new AppIntrospectionCompiler())->compile($contextName);
        $locations = self::locationsByRouteName($artifact);

        $routes = [];
        foreach ($collection as $name => $route) {
            $defaults = $route->getDefaults();
            if ($module !== null && !self::matches($defaults['_module'] ?? null, $module)) {
                continue;
            }
            if ($action !== null && !self::matches($defaults['_action'] ?? null, $action)) {
                continue;
            }

            $location = $locations[$name] ?? ['file' => null, 'line' => null];

            $routes[] = [
                'name' => $name,
                'path' => $route->getPath(),
                'methods' => array_values($route->getMethods()) ?: ['ANY'],
                'defaults' => $defaults,
                'requirements' => $route->getRequirements(),
                'file' => $location['file'],
                'line' => $location['line'],
            ];
        }

        return [
            '_schema_version' => 1,
            'context' => $contextName,
            'module_filter' => $module,
            'action_filter' => $action,
            'count' => count($routes),
            'routes' => $routes,
            'diagnostics' => $artifact['diagnostics'],
        ];
    }

    /**
     * @param array{routes: list<array{name: string, file: ?string, line: ?int}>} $artifact
     * @return array<string, array{file: ?string, line: ?int}>
     */
    private static function locationsByRouteName(array $artifact): array
    {
        $locations = [];
        foreach ($artifact['routes'] as $route) {
            $locations[$route['name']] = ['file' => $route['file'], 'line' => $route['line']];
        }
        return $locations;
    }

    private static function matches(mixed $defaultValue, string $filter): bool
    {
        return is_string($defaultValue) && strcasecmp($defaultValue, $filter) === 0;
    }
}
