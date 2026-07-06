<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Introspection\Capabilities;

use Quiote\Context;

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
     * @return array<string, mixed>
     */
    public static function run(string $contextName, ?string $module = null, ?string $action = null): array
    {
        $routing = Context::getInstance($contextName)->getRouting();
        $collection = $routing->getRouteCollection();

        $routes = [];
        foreach ($collection as $name => $route) {
            $defaults = $route->getDefaults();
            if ($module !== null && !self::matches($defaults['_module'] ?? null, $module)) {
                continue;
            }
            if ($action !== null && !self::matches($defaults['_action'] ?? null, $action)) {
                continue;
            }

            $routes[] = [
                'name' => $name,
                'path' => $route->getPath(),
                'methods' => $route->getMethods() ?: ['ANY'],
                'defaults' => $defaults,
                'requirements' => $route->getRequirements(),
            ];
        }

        return [
            'context' => $contextName,
            'module_filter' => $module,
            'action_filter' => $action,
            'count' => count($routes),
            'routes' => $routes,
        ];
    }

    private static function matches(mixed $defaultValue, string $filter): bool
    {
        return is_string($defaultValue) && strcasecmp($defaultValue, $filter) === 0;
    }
}
