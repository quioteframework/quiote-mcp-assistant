<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Tools;

use QuioteMcpAssistant\Mcp\Introspection\TargetAppIntrospector;

/** `scaffold_action(module, action, verbs?, formats?, dry_run?)` -- one new action + its view + template(s). */
final class ScaffoldActionTool
{
    public function __construct(private readonly TargetAppIntrospector $introspector) {}

    /**
     * @param list<string> $verbs one or more of read/write/update/remove (default: read)
     * @param list<string> $formats one or more output type names, e.g. html/json (default: html)
     * @return array<string, mixed>
     */
    public function scaffold(string $module, string $action, array $verbs = ['read'], array $formats = ['html'], bool $dry_run = true): array
    {
        return $this->introspector->run('scaffold_action', [
            'module' => $module,
            'action' => $action,
            'verbs' => implode(',', $verbs),
            'formats' => implode(',', $formats),
            'dry-run' => $dry_run ? '1' : '0',
        ]);
    }
}
