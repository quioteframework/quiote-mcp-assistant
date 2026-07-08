<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Tools;

use QuioteMcpAssistant\Mcp\Introspection\TargetAppIntrospector;

/**
 * `validate_config(key?)` -- runs the config validator (syntax + semantic +
 * array-shape schema layers, format-agnostic across PHP/YAML/XML) against
 * one logical config in the target app, or all known ones if `key` is
 * omitted. See VSCODE_EXTENSION_INTEGRATION.md §4.
 */
final class ValidateConfigTool
{
    public function __construct(private readonly TargetAppIntrospector $introspector) {}

    /** @return array<string, mixed> */
    public function validate(string $key = ''): array
    {
        return $this->introspector->run('validate_config', $key !== '' ? ['key' => $key] : []);
    }
}
