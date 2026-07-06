<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Tools;

use QuioteMcpAssistant\Mcp\Introspection\TargetAppIntrospector;

/** `read_config(key?)` -- an allowlisted `Config::get()` over the target app; omit `key` to see the allowlist. */
final class ReadConfigTool
{
    public function __construct(private readonly TargetAppIntrospector $introspector) {}

    /** @return array<string, mixed> */
    public function read(string $key = ''): array
    {
        return $this->introspector->run('config', $key !== '' ? ['key' => $key] : []);
    }
}
