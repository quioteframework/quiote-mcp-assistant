<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Integration\Mcp\Introspection\Capabilities;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use QuioteMcpAssistant\Mcp\Introspection\Capabilities\ScaffoldDbConnection;

/**
 * `core.config_dir` is readonly-locked by this test process's own bootstrap,
 * so the "Config/databases.xml doesn't exist yet -- create it" branch (which
 * needs a *different* config_dir) can only be reached from a genuinely
 * separate PHP process -- same reasoning as ScaffoldOutputTypesTest.
 */
final class ScaffoldDbConnectionTest extends TestCase
{
    #[Test]
    public function refusesToTouchThisAppsOwnExistingDatabasesXml(): void
    {
        // This app's own Config/databases.xml already exists, so this branch
        // never calls ScaffoldWriter -- safe to call directly regardless of
        // dry_run, unlike the create-a-new-file branch (see ScaffoldModuleTest's
        // docblock for why that one would need real subprocess isolation).
        $result = ScaffoldDbConnection::run('/irrelevant-app-dir', 'phpunittestconnection', 'pdo', dryRun: true);

        self::assertSame('exists_manual_edit_required', $result['status']);
        self::assertSame('Config/databases.xml', $result['file']);
        self::assertIsString($result['snippet']);
        self::assertStringContainsString('phpunittestconnection', $result['snippet']);
        self::assertStringContainsString('Quiote\Database\PdoDatabase', $result['snippet']);
    }

    #[Test]
    public function rejectsAnUnknownDriver(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Unknown driver');

        ScaffoldDbConnection::run('/irrelevant-app-dir', 'main', 'notadriver', dryRun: true);
    }

    #[Test]
    public function rejectsAConnectionNameThatIsNotAValidLabelEvenAfterCapitalization(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid connection name');

        ScaffoldDbConnection::run('/irrelevant-app-dir', 'not_a_valid_name', 'pdo', dryRun: true);
    }

    #[Test]
    public function createsAFreshDatabasesXmlWhenNoneExistsYet(): void
    {
        $configDir = sys_get_temp_dir() . '/scaffold-db-connection-test-' . bin2hex(random_bytes(8));
        mkdir($configDir, 0o775, true);

        try {
            $result = $this->runInASeparateProcess($configDir);

            self::assertIsArray($result['files']);
            $file = $result['files'][0];
            self::assertIsArray($file);
            self::assertSame('created', $file['status']);

            $written = file_get_contents("{$configDir}/databases.xml");
            self::assertIsString($written);
            self::assertStringContainsString('<databases default="main">', $written);
            self::assertStringContainsString('Quiote\Database\PdoDatabase', $written);
        } finally {
            @unlink("{$configDir}/databases.xml");
            rmdir($configDir);
        }
    }

    /** @return array<string, mixed> */
    private function runInASeparateProcess(string $configDir): array
    {
        $repoRoot = dirname(__DIR__, 5);

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
            echo json_encode(\\QuioteMcpAssistant\\Mcp\\Introspection\\Capabilities\\ScaffoldDbConnection::run(
                '{$configDir}',
                'main',
                'pdo',
                false,
            ));
            PHP;

        $tmpScript = tempnam(sys_get_temp_dir(), 'scaffold-db-connection-probe-') . '.php';
        file_put_contents($tmpScript, $script);

        try {
            $output = shell_exec('php ' . escapeshellarg($tmpScript) . ' 2>&1');
            self::assertIsString($output, 'Subprocess produced no output.');

            $decoded = json_decode($output, true);
            self::assertIsArray($decoded, "Subprocess did not return valid JSON:\n{$output}");

            $result = [];
            foreach ($decoded as $key => $value) {
                if (is_string($key)) {
                    $result[$key] = $value;
                }
            }

            return $result;
        } finally {
            unlink($tmpScript);
        }
    }
}
