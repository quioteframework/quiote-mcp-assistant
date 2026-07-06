<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Tools;

use QuioteMcpAssistant\Mcp\Introspection\TargetAppIntrospector;

/** `list_db_connections` -- adapter + parameter names (never values) per configured connection. */
final class ListDbConnectionsTool
{
    public function __construct(private readonly TargetAppIntrospector $introspector) {}

    /** @return array<string, mixed> */
    public function list(): array
    {
        return $this->introspector->run('db');
    }
}
