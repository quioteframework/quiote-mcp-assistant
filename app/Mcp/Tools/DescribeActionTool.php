<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Tools;

use QuioteMcpAssistant\Mcp\Introspection\TargetAppIntrospector;

/** `describe_action("Module.Action")` -- verbs, validator-derived schemas, credentials, default view. */
final class DescribeActionTool
{
    public function __construct(private readonly TargetAppIntrospector $introspector) {}

    /** @return array<string, mixed> */
    public function describe(string $action): array
    {
        if (!str_contains($action, '.')) {
            return ['error' => 'Expected "Module.Action", e.g. "Blog.Post".', 'action' => $action];
        }

        [$module, $actionName] = explode('.', $action, 2);

        return $this->introspector->run('action', ['module' => $module, 'action' => $actionName]);
    }
}
