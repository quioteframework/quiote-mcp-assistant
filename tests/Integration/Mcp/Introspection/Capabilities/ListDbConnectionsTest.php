<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Integration\Mcp\Introspection\Capabilities;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use QuioteMcpAssistant\Mcp\Introspection\Capabilities\ListDbConnections;

final class ListDbConnectionsTest extends TestCase
{
    #[Test]
    public function findsTheRealDefaultConnectionAndNeverLeaksValues(): void
    {
        $result = ListDbConnections::run();

        self::assertTrue($result['found']);
        self::assertSame('default', $result['default']);
        self::assertIsArray($result['databases']);
        self::assertArrayHasKey('default', $result['databases']);
        $default = $result['databases']['default'];
        self::assertIsArray($default);
        self::assertSame('Quiote\Database\PdoDatabase', $default['class']);
        // Safety-critical: only parameter *names*, never values (DSNs/credentials).
        self::assertSame(['dsn'], $default['parameter_keys']);
        self::assertArrayNotHasKey('parameters', $default);
        self::assertSame('xml', $result['format']);
    }

    /**
     * A databases config may be written as PHP, YAML or XML, and the framework
     * resolves `.php` > `.yaml` > `.xml`. Reporting only what `databases.xml`
     * says would describe a connection the app does not actually use whenever a
     * PHP sibling exists -- so this pins the precedence, not just the parsing.
     */
    #[Test]
    public function readsAPhpDatabasesConfigAndPrefersItOverAnXmlSibling(): void
    {
        $dir = $this->makeTempConfigDir();

        file_put_contents($dir . '/databases.php', <<<'PHP'
            <?php
            return [
                'default' => 'reporting',
                'databases' => [
                    'reporting' => [
                        'class' => 'Quiote\Database\PdoDatabase',
                        'parameters' => ['dsn' => 'pgsql:host=localhost;dbname=reporting', 'password' => 'hunter2'],
                    ],
                ],
            ];
            PHP);

        file_put_contents($dir . '/databases.xml', <<<'XML'
            <?xml version="1.0" encoding="UTF-8"?>
            <ae:configurations xmlns:ae="http://quiote.dev/quiote/config/global/envelope/1.1"
                xmlns="http://quiote.dev/quiote/config/parts/databases/1.1">
                <ae:configuration>
                    <databases default="ignored">
                        <database name="ignored" class="Quiote\Database\PdoDatabase">
                            <ae:parameter name="dsn">sqlite::memory:</ae:parameter>
                        </database>
                    </databases>
                </ae:configuration>
            </ae:configurations>
            XML);

        $result = ListDbConnections::run($dir);

        self::assertTrue($result['found']);
        self::assertSame('php', $result['format']);
        self::assertSame('reporting', $result['default']);
        self::assertIsArray($result['databases']);
        self::assertArrayNotHasKey('ignored', $result['databases']);
        $reporting = $result['databases']['reporting'];
        self::assertIsArray($reporting);
        self::assertSame('Quiote\Database\PdoDatabase', $reporting['class']);
        // Safety-critical, and the PHP path is no exception: names only.
        self::assertSame(['dsn', 'password'], $reporting['parameter_keys']);
        self::assertStringNotContainsString('hunter2', json_encode($result, JSON_THROW_ON_ERROR));
    }

    #[Test]
    public function reportsNotFoundWhenNoDatabasesConfigExistsInAnyFormat(): void
    {
        $result = ListDbConnections::run($this->makeTempConfigDir());

        self::assertFalse($result['found']);
        self::assertNull($result['format']);
        self::assertNull($result['default']);
        self::assertSame([], $result['databases']);
    }

    private function makeTempConfigDir(): string
    {
        $dir = sys_get_temp_dir() . '/ldbc_' . bin2hex(random_bytes(6));
        mkdir($dir);
        $this->tempDirs[] = $dir;

        return $dir;
    }

    /** @var list<string> */
    private array $tempDirs = [];

    protected function tearDown(): void
    {
        foreach ($this->tempDirs as $dir) {
            foreach (glob($dir . '/*') ?: [] as $file) {
                unlink($file);
            }
            rmdir($dir);
        }
        $this->tempDirs = [];
        parent::tearDown();
    }
}
