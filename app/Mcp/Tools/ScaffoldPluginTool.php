<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Tools;

use QuioteMcpAssistant\Mcp\Introspection\TargetAppIntrospector;

/** `scaffold_plugin(name, dry_run?)` -- a new plugin class (never auto-registers it -- see `next_step`). */
final class ScaffoldPluginTool
{
    public function __construct(private readonly TargetAppIntrospector $introspector) {}

    /** @return array<string, mixed> */
    public function scaffold(string $name, bool $dry_run = true): array
    {
        return $this->introspector->run('scaffold_plugin', [
            'plugin' => $name,
            'dry-run' => $dry_run ? '1' : '0',
        ]);
    }
}
