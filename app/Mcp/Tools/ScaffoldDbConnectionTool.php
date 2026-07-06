<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Tools;

use QuioteMcpAssistant\Mcp\Introspection\TargetAppIntrospector;

/**
 * `scaffold_db_connection(name, driver?, dry_run?)` -- creates
 * `Config/databases.xml` if it doesn't exist yet, otherwise returns a
 * ready-to-paste snippet (never edits an existing file).
 */
final class ScaffoldDbConnectionTool
{
    public function __construct(private readonly TargetAppIntrospector $introspector) {}

    /** @return array<string, mixed> */
    public function scaffold(string $name, string $driver = 'pdo', bool $dry_run = true): array
    {
        return $this->introspector->run('scaffold_db_connection', [
            'connection' => $name,
            'driver' => $driver,
            'dry-run' => $dry_run ? '1' : '0',
        ]);
    }
}
