<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Integration\Mcp\Introspection\Capabilities;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use QuioteMcpAssistant\Mcp\Introspection\Capabilities\ScaffoldOutputTypes;

/**
 * `core.config_dir` is readonly-locked by this test process's own bootstrap
 * (tests/bootstrap.php), the same static/process-wide Config constraint
 * documented throughout `probe.php` -- so the "config file missing" and
 * "config file doesn't parse" branches, which need a *different*
 * `core.config_dir`, can only be exercised from a genuinely separate PHP
 * process, not by re-pointing Config mid-test. This mirrors exactly why
 * this app's own project-aware tools run target-app introspection in an
 * isolated subprocess rather than in-process.
 */
final class ScaffoldOutputTypesTest extends TestCase
{
    #[Test]
    public function declaredFindsTheRealAppsOwnHtmlOutputType(): void
    {
        // Same-process happy path: this test suite's own bootstrap already
        // points core.config_dir at this app's real Config/, which declares
        // "html" (see app/Config/output_types.xml).
        self::assertContains('html', ScaffoldOutputTypes::declared());
    }

    #[Test]
    public function declaredReturnsEmptyWhenOutputTypesXmlDoesNotExist(): void
    {
        $configDir = sys_get_temp_dir() . '/scaffold-output-types-test-' . bin2hex(random_bytes(8));
        mkdir($configDir, 0o775, true);

        try {
            $result = $this->declaredInASeparateProcess($configDir);
            self::assertSame([], $result);
        } finally {
            rmdir($configDir);
        }
    }

    #[Test]
    public function declaredReturnsEmptyWhenOutputTypesXmlDoesNotParse(): void
    {
        $configDir = sys_get_temp_dir() . '/scaffold-output-types-test-' . bin2hex(random_bytes(8));
        mkdir($configDir, 0o775, true);
        file_put_contents("{$configDir}/output_types.xml", 'this is not xml at all <<<');

        try {
            $result = $this->declaredInASeparateProcess($configDir);
            self::assertSame([], $result);
        } finally {
            unlink("{$configDir}/output_types.xml");
            rmdir($configDir);
        }
    }

    /** @return list<string> */
    private function declaredInASeparateProcess(string $configDir): array
    {
        $repoRoot = dirname(__DIR__, 5);
        $quioteDir = $repoRoot . '/vendor/quioteframework/quiote';

        $script = <<<PHP
            <?php
            require '{$repoRoot}/vendor/autoload.php';
            spl_autoload_register(static function (string \$class): void {
                \$prefix = 'QuioteMcpAssistant\\\\';
                if (!str_starts_with(\$class, \$prefix)) return;
                \$file = '{$repoRoot}/app/' . str_replace('\\\\', '/', substr(\$class, strlen(\$prefix))) . '.php';
                if (is_file(\$file)) require \$file;
            });
            \\Quiote\\Config\\Config::set('core.config_dir', '{$configDir}');
            \\Quiote\\Config\\Config::set('core.quiote_dir', '{$quioteDir}');
            \\Quiote\\Config\\Config::set('core.environment', 'development');
            echo json_encode(\\QuioteMcpAssistant\\Mcp\\Introspection\\Capabilities\\ScaffoldOutputTypes::declared());
            PHP;

        $tmpScript = tempnam(sys_get_temp_dir(), 'scaffold-output-types-probe-') . '.php';
        file_put_contents($tmpScript, $script);

        try {
            $output = shell_exec('php ' . escapeshellarg($tmpScript) . ' 2>&1');
            self::assertIsString($output, 'Subprocess produced no output.');

            $decoded = json_decode($output, true);
            self::assertIsArray($decoded, "Subprocess did not return valid JSON:\n{$output}");

            // declared() is documented to return a list<string> of output
            // type names -- filtering to is_string (rather than casting)
            // keeps that guarantee honest instead of coercing a malformed
            // subprocess response into looking like a valid one.
            return array_values(array_filter($decoded, 'is_string'));
        } finally {
            unlink($tmpScript);
        }
    }
}
