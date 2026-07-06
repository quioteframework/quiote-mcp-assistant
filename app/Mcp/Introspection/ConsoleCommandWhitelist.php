<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Introspection;

/**
 * The `run_console` allowlist: non-destructive console commands only, each
 * with its own allowlisted option set -- `args` is never passed through
 * unfiltered, since an unlisted option could change environment/config in
 * ways this tool has no business allowing (e.g. an `--env=` override).
 *
 * `cache:warmup` *does* write to `{app_dir}/cache/**` -- allowed anyway
 * because that's a regenerable build artifact, never user source or data
 * (it's the same class of safety as scaffolding: file writes are fine,
 * destructive ones aren't).
 */
final class ConsoleCommandWhitelist
{
    /** @var array<string, array{flags: list<string>, valued: list<string>}> */
    private const COMMANDS = [
        'about' => ['flags' => [], 'valued' => []],
        'routes:list' => ['flags' => ['json'], 'valued' => ['context', 'module', 'action', 'sort']],
        'cache:warmup' => ['flags' => ['check'], 'valued' => ['context']],
    ];

    /** @return list<string> */
    public static function commands(): array
    {
        return array_keys(self::COMMANDS);
    }

    public static function isAllowed(string $command): bool
    {
        return isset(self::COMMANDS[$command]);
    }

    /**
     * @param array<string, mixed> $args
     * @return array{0: list<string>, 1: list<string>} [validArgv, rejectedKeys]
     */
    public static function toArgv(string $command, array $args): array
    {
        $spec = self::COMMANDS[$command] ?? ['flags' => [], 'valued' => []];
        $argv = [];
        $rejected = [];

        foreach ($args as $key => $value) {
            if (in_array($key, $spec['flags'], true)) {
                if ((bool) $value) {
                    $argv[] = '--' . $key;
                }
                continue;
            }
            if (in_array($key, $spec['valued'], true)) {
                if (!is_scalar($value)) {
                    $rejected[] = (string) $key;
                    continue;
                }
                $argv[] = '--' . $key . '=' . (string) $value;
                continue;
            }
            $rejected[] = (string) $key;
        }

        return [$argv, $rejected];
    }
}
