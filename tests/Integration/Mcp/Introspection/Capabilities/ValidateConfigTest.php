<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Integration\Mcp\Introspection\Capabilities;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use QuioteMcpAssistant\Mcp\Introspection\Capabilities\ValidateConfig;

final class ValidateConfigTest extends TestCase
{
    #[Test]
    public function theRealAppConfigsAreClean(): void
    {
        // This app's own Config/ deliberately mixes formats (settings.php,
        // factories.yaml, databases.xml, output_types.xml) -- a clean
        // "validate all" run here exercises format-agnostic resolution,
        // XSL upgrade + XSD validation, and schema checking across all
        // three formats in one assertion.
        $result = ValidateConfig::run('');

        self::assertSame(1, $result['_schema_version']);
        self::assertSame([], $result['diagnostics']);
    }

    #[Test]
    public function anUnknownKeyIsRefused(): void
    {
        $result = ValidateConfig::run('not_a_real_config');

        self::assertSame([], $result['diagnostics']);
        self::assertStringContainsString('Unknown config key', $result['error'] ?? '');
    }

    #[Test]
    public function anExplicitlyRequestedMissingOptionalConfigIsReported(): void
    {
        // Neither middleware.xml/.php/.yaml exists under this app's Config/.
        $result = ValidateConfig::run('middleware');

        self::assertCount(1, $result['diagnostics']);
        self::assertSame('config.missing', $result['diagnostics'][0]['code']);
        self::assertSame('error', $result['diagnostics'][0]['severity']);
    }

    #[Test]
    public function aMissingOptionalConfigIsSilentWhenValidatingEverything(): void
    {
        // "validate all" shouldn't flag optional, absent configs
        // (plugins/middleware/rbac_definitions/translation) as errors --
        // only settings is mandatory.
        $result = ValidateConfig::run('');

        $codes = array_column($result['diagnostics'], 'code');
        self::assertNotContains('config.missing', $codes);
    }
}
