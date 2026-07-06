<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Tools;

use QuioteMcpAssistant\Mcp\Introspection\TargetAppIntrospector;

/** `scaffold_module(module, dry_run?)` -- a new module skeleton (Index action + view + template). */
final class ScaffoldModuleTool
{
    public function __construct(private readonly TargetAppIntrospector $introspector) {}

    /** @return array<string, mixed> */
    public function scaffold(string $module, bool $dry_run = true): array
    {
        return $this->introspector->run('scaffold_module', [
            'module' => $module,
            'dry-run' => $dry_run ? '1' : '0',
        ]);
    }
}
