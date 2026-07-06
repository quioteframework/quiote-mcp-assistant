<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Introspection;

use QuioteMcpAssistant\Mcp\Support\Cfg;

/**
 * Runs one of `vendor/bin/quiote`'s own whitelisted commands (see
 * {@see ConsoleCommandWhitelist}) against the configured target app, via
 * {@see IsolatedProcess} -- these are the framework's real commands, each
 * bootstrapping the target app fresh in its own subprocess exactly the way
 * a developer running them by hand would, so no separate isolation trick is
 * needed beyond the same stdin/timeout safety every subprocess here uses.
 */
final class ConsoleRunner
{
    /**
     * @param array<string, mixed> $args
     * @return array<string, mixed>
     */
    public function run(string $command, array $args = []): array
    {
        $appDir = trim(Cfg::string('assistant.target_app_dir'));
        if ($appDir === '') {
            return ['error' => 'No target app configured. Launch bin/quiote-assistant with --target-app-dir=/path/to/app to enable project-aware tools.'];
        }
        if (!is_dir($appDir)) {
            return ['error' => sprintf('Configured target app directory "%s" does not exist.', $appDir)];
        }

        if (!ConsoleCommandWhitelist::isAllowed($command)) {
            return [
                'error' => sprintf('"%s" is not a whitelisted command.', $command),
                'allowed_commands' => ConsoleCommandWhitelist::commands(),
            ];
        }

        [$argv, $rejected] = ConsoleCommandWhitelist::toArgv($command, $args);
        if ($rejected !== []) {
            return ['error' => sprintf('Unsupported option(s) for "%s": %s', $command, implode(', ', $rejected))];
        }

        $quioteBin = dirname(__DIR__, 3) . '/vendor/bin/quiote';
        $fullCommand = IsolatedProcess::scriptCommand(
            $quioteBin,
            array_merge([$command, '--app-dir=' . $appDir, '--no-interaction'], $argv),
        );

        $result = IsolatedProcess::run($fullCommand);

        if ($result['timedOut']) {
            return ['error' => sprintf('"%s" timed out.', $command)];
        }

        return [
            '_source' => 'target-app-untrusted',
            'command' => $command,
            'exit_code' => $result['exitCode'],
            'output' => trim($result['stdout']),
            'stderr' => trim($result['stderr']),
        ];
    }
}
