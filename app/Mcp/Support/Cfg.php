<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Support;

use Quiote\Config\Config;

/**
 * Typed wrapper over `Quiote\Config\Config::get()`, which has no PHPDoc types
 * at all (bare `mixed` in, `mixed` out). Casting that straight to `string`
 * (`(string) Config::get(...)`, previously scattered across this app) is
 * unsound -- a misconfigured or wrong-typed setting could be an array, which
 * fatals on cast rather than degrading to the caller's default. This
 * validates the actual runtime type instead of assuming it.
 */
final class Cfg
{
    public static function string(string $key, string $default = ''): string
    {
        $value = Config::get($key, $default);

        return is_string($value) ? $value : $default;
    }
}
