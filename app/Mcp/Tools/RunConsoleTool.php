<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Tools;

use QuioteMcpAssistant\Mcp\Introspection\ConsoleCommandWhitelist;
use QuioteMcpAssistant\Mcp\Introspection\ConsoleRunner;

/**
 * `run_console(command, args?)` -- a whitelisted, non-destructive subset of
 * the target app's own console commands: `about`, `routes:list`,
 * `cache:warmup`. Never migrations/deletes; unlisted commands and unlisted
 * options are refused, not silently dropped.
 */
final class RunConsoleTool
{
    public function __construct(private readonly ConsoleRunner $runner) {}

    /**
     * @param array<string, mixed> $args
     * @return array<string, mixed>
     */
    public function run(string $command, array $args = []): array
    {
        if (!ConsoleCommandWhitelist::isAllowed($command)) {
            return [
                'error' => sprintf('"%s" is not a whitelisted command.', $command),
                'allowed_commands' => ConsoleCommandWhitelist::commands(),
            ];
        }

        return $this->runner->run($command, $args);
    }
}
