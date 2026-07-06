<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Tools;

use QuioteMcpAssistant\Mcp\Introspection\TargetAppIntrospector;

/** `list_routes(module?, action?)` -- every route the target app's live RouteCollection resolves with, optionally filtered. */
final class ListRoutesTool
{
    public function __construct(private readonly TargetAppIntrospector $introspector) {}

    /** @return array<string, mixed> */
    public function list(?string $module = null, ?string $action = null): array
    {
        $args = [];
        if ($module !== null) {
            $args['module'] = $module;
        }
        if ($action !== null) {
            $args['action'] = $action;
        }

        return $this->introspector->run('routes', $args);
    }
}
