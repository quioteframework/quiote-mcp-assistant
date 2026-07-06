<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Tools;

use QuioteMcpAssistant\Mcp\Introspection\TargetAppIntrospector;

/** `project_info` -- overview of the configured target Quiote app. */
final class ProjectInfoTool
{
    public function __construct(private readonly TargetAppIntrospector $introspector) {}

    /** @return array<string, mixed> */
    public function info(): array
    {
        return $this->introspector->run('project_info');
    }
}
