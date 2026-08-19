<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Integration\Mcp\Introspection\Capabilities;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Quiote\Config\Config;
use Quiote\Replay\Cassette\Cassette;
use Quiote\Replay\Cassette\CassetteCodec;
use Quiote\Replay\Cassette\CassetteId;
use Quiote\Replay\Store\FileCassetteStore;
use QuioteMcpAssistant\Mcp\Introspection\Capabilities\EmitReplayTest;

/**
 * core.app_dir is locked readonly by tests/bootstrap.php (Quiote\Config\Config::set()'s own
 * $readonly flag), so unlike replay.store.path/replay.local_path this cannot be pointed at a
 * disposable temp directory for the test -- ReplayTestEmission::emit() always writes under this
 * app's own real {core.app_dir}/tests/Replay/, exactly as the real subprocess-based
 * EmitReplayTestToolTest does. Cleanup deletes the specific files/directories this test creates by
 * name rather than an isolated tree.
 */
final class EmitReplayTestTest extends TestCase
{
    private ?string $seededId = null;

    /** @var list<string> */
    private array $filesToDelete = [];

    protected function tearDown(): void
    {
        if ($this->seededId !== null) {
            $id = CassetteId::fromRaw($this->seededId);
            (new FileCassetteStore(Config::getString('replay.store.path')))->delete($id);
            (new FileCassetteStore(Config::getString('replay.local_path')))->delete($id);
            $this->seededId = null;
        }
        foreach ($this->filesToDelete as $path) {
            @unlink($path);
        }
        $this->filesToDelete = [];
        @rmdir($this->appDir() . '/tests/Replay/cassettes');
        @rmdir($this->appDir() . '/tests/Replay');
        @rmdir($this->appDir() . '/tests');
        parent::tearDown();
    }

    private function appDir(): string
    {
        return Config::getString('core.app_dir');
    }

    private function seed(string $rawId): void
    {
        $store = new FileCassetteStore(Config::getString('replay.store.path'));
        $cassette = new Cassette(
            schemaVersion: CassetteCodec::CURRENT_SCHEMA_VERSION,
            meta: ['id' => $rawId, 'context' => 'web'],
            request: ['method' => 'GET', 'uri' => '/', 'headers' => [], 'cookies' => [], 'body' => ['encoding' => 'utf8', 'content' => '', 'truncated' => false], 'server' => []],
            resolved: [],
            session: null,
            user: null,
            effects: [],
            response: ['status' => 200, 'headers' => [], 'body' => ['encoding' => 'utf8', 'content' => '', 'truncated' => false]],
            exception: null,
            log: null,
        );
        $store->put(CassetteId::fromRaw($rawId), $cassette);
        $this->seededId = $rawId;
    }

    #[Test]
    public function writesTheTestAndCassetteCopy(): void
    {
        $this->seed('ERT-AAA');

        $result = EmitReplayTest::run('web', 'ERT-AAA');

        self::assertSame('ERT-AAA', $result['id']);
        $testPath = $result['test'];
        $cassettePath = $result['cassette'];
        self::assertIsString($testPath);
        self::assertIsString($cassettePath);
        $this->filesToDelete[] = $testPath;
        $this->filesToDelete[] = $cassettePath;
        self::assertFileExists($testPath);
        self::assertFileExists($cassettePath);
        self::assertStringContainsString('extends ReplayTestCase', (string) file_get_contents($testPath));
    }

    #[Test]
    public function expectFixedEmitsTheIncompleteSkeleton(): void
    {
        $this->seed('ERT-FIXED');

        $result = EmitReplayTest::run('web', 'ERT-FIXED', expectFixed: true);

        $testPath = $result['test'];
        $cassettePath = $result['cassette'];
        self::assertIsString($testPath);
        self::assertIsString($cassettePath);
        $this->filesToDelete[] = $testPath;
        $this->filesToDelete[] = $cassettePath;
        self::assertStringContainsString('markTestIncomplete', (string) file_get_contents($testPath));
    }
}
