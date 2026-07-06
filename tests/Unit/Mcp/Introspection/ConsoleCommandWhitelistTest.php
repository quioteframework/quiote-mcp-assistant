<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Unit\Mcp\Introspection;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use QuioteMcpAssistant\Mcp\Introspection\ConsoleCommandWhitelist;

final class ConsoleCommandWhitelistTest extends TestCase
{
    #[Test]
    public function commandsListsTheKnownAllowlist(): void
    {
        self::assertSame(['about', 'routes:list', 'cache:warmup'], ConsoleCommandWhitelist::commands());
    }

    #[Test]
    public function isAllowedAcceptsWhitelistedCommands(): void
    {
        self::assertTrue(ConsoleCommandWhitelist::isAllowed('routes:list'));
    }

    #[Test]
    public function isAllowedRejectsAnythingNotWhitelisted(): void
    {
        self::assertFalse(ConsoleCommandWhitelist::isAllowed('migrate'));
    }

    #[Test]
    public function toArgvBuildsAFlagOnlyWhenTruthy(): void
    {
        [$argv, $rejected] = ConsoleCommandWhitelist::toArgv('routes:list', ['json' => true]);

        self::assertSame(['--json'], $argv);
        self::assertSame([], $rejected);
    }

    #[Test]
    public function toArgvOmitsAFalsyFlagEntirely(): void
    {
        [$argv, $rejected] = ConsoleCommandWhitelist::toArgv('routes:list', ['json' => false]);

        self::assertSame([], $argv);
        self::assertSame([], $rejected);
    }

    #[Test]
    public function toArgvBuildsAValuedOption(): void
    {
        [$argv, $rejected] = ConsoleCommandWhitelist::toArgv('routes:list', ['context' => 'web']);

        self::assertSame(['--context=web'], $argv);
        self::assertSame([], $rejected);
    }

    #[Test]
    public function toArgvRejectsAnOptionNotInTheCommandsSpec(): void
    {
        // "env" is a real Symfony Console option, but not one this command's
        // allowlist opts into -- must be refused, never silently dropped or
        // passed through.
        [$argv, $rejected] = ConsoleCommandWhitelist::toArgv('cache:warmup', ['env' => 'production']);

        self::assertSame([], $argv);
        self::assertSame(['env'], $rejected);
    }

    #[Test]
    public function toArgvRejectsANonScalarValueForAValuedOption(): void
    {
        // A JSON tool-call argument can be an array/object; casting that
        // straight to string would produce a nonsensical "--context=Array"
        // argv token rather than failing loudly. Must be rejected instead.
        [$argv, $rejected] = ConsoleCommandWhitelist::toArgv('routes:list', ['context' => ['nested' => true]]);

        self::assertSame([], $argv);
        self::assertSame(['context'], $rejected);
    }

    #[Test]
    public function toArgvRejectsEverythingForAnUnknownCommand(): void
    {
        [$argv, $rejected] = ConsoleCommandWhitelist::toArgv('migrate', ['force' => true]);

        self::assertSame([], $argv);
        self::assertSame(['force'], $rejected);
    }
}
