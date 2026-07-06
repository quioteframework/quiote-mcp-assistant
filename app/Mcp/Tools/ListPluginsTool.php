<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Tools;

use QuioteMcpAssistant\Mcp\Introspection\TargetAppIntrospector;

/** `list_plugins` -- plugins registered during the target app's bootstrap. */
final class ListPluginsTool
{
    public function __construct(private readonly TargetAppIntrospector $introspector) {}

    /** @return array<string, mixed> */
    public function list(): array
    {
        return $this->introspector->run('plugins');
    }
}
