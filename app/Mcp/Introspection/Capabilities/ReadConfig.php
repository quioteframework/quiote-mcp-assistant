<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Introspection\Capabilities;

use Quiote\Config\Config;

/**
 * `read_config(key)` -- `Config::get()` over an explicit **allowlist**, not a
 * denylist or prefix match. `core.*`/`mcp.*`/etc. are one flat namespace that
 * also holds secrets (`mcp.auth_token`, and `databases.xml` credentials via
 * other handlers) -- an unfiltered `Config::toArray()` or a prefix like
 * `mcp.*` would leak them. Only settings confirmed safe to disclose are
 * listed; everything else is refused, never silently redacted.
 */
final class ReadConfig
{
    private const ALLOWED_KEYS = [
        'core.app_name',
        'core.namespace_prefix',
        'core.available',
        'core.debug',
        'core.use_database',
        'core.use_logging',
        'core.use_security',
        'core.use_translation',
        'core.default_context',
        'core.environment',
        'routing.http_method_map',
        'mcp.enabled',
        'mcp.transports',
        'mcp.expose_actions',
        'mcp.server_name',
        'mcp.server_version',
        'plugins',
    ];

    /**
     * @return array{
     *     _schema_version: int,
     *     allowed_keys?: list<string>,
     *     key?: string,
     *     error?: string,
     *     value?: mixed,
     * }
     */
    public static function run(string $key): array
    {
        if ($key === '') {
            return ['_schema_version' => 1, 'allowed_keys' => self::ALLOWED_KEYS];
        }

        if (!in_array($key, self::ALLOWED_KEYS, true)) {
            return [
                '_schema_version' => 1,
                'key' => $key,
                'error' => 'Not a whitelisted key.',
                'allowed_keys' => self::ALLOWED_KEYS,
            ];
        }

        return ['_schema_version' => 1, 'key' => $key, 'value' => Config::get($key)];
    }
}
