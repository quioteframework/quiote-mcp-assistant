<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Integration\Mcp\Introspection\Capabilities;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use QuioteMcpAssistant\Mcp\Introspection\Capabilities\ScaffoldModule;

/**
 * `core.module_dir` is readonly-locked to this app's own `app/Modules` in
 * this test process (see ScaffoldOutputTypesTest's docblock for the general
 * pattern) -- ScaffoldWriter writes to the *absolute* path this capability
 * builds from that Config key, not the `$appDir` parameter, so a real
 * (non-dry-run) write here would land in this repo's own app/Modules.
 * Deliberately only ever previews (dry_run: true), same rule as
 * ScaffoldModuleToolTest; real-write behavior is covered there via
 * tools/mcp-smoke-client-scaffold.php against a disposable scratch app.
 */
final class ScaffoldModuleTest extends TestCase
{
    #[Test]
    public function previewsTheThreeGeneratedFilesWithoutWriting(): void
    {
        $result = ScaffoldModule::run('/irrelevant-app-dir', 'PhpunitCapabilityPreview', dryRun: true);

        self::assertSame('PhpunitCapabilityPreview', $result['module']);
        self::assertTrue($result['dry_run']);
        self::assertIsArray($result['files']);
        self::assertCount(3, $result['files']);
        foreach ($result['files'] as $file) {
            self::assertIsArray($file);
            self::assertSame('would_create', $file['status']);
        }
        self::assertFileDoesNotExist(dirname(__DIR__, 5) . '/app/Modules/PhpunitCapabilityPreview');
    }

    #[Test]
    public function rejectsANonPascalCaseModuleName(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid module name');

        ScaffoldModule::run('/irrelevant-app-dir', 'not-pascal-case', dryRun: true);
    }
}
