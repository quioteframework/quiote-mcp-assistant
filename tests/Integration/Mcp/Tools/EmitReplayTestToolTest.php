<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Integration\Mcp\Tools;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Quiote\Config\Config;
use Quiote\Replay\Cassette\Cassette;
use Quiote\Replay\Cassette\CassetteCodec;
use Quiote\Replay\Cassette\CassetteId;
use Quiote\Replay\Store\FileCassetteStore;
use QuioteMcpAssistant\Mcp\Introspection\TargetAppIntrospector;
use QuioteMcpAssistant\Mcp\Tools\EmitReplayTestTool;

final class EmitReplayTestToolTest extends TestCase
{
    private ?string $seededId = null;

    protected function setUp(): void
    {
        Config::set('assistant.target_app_dir', dirname(__DIR__, 4) . '/app');
    }

    protected function tearDown(): void
    {
        Config::remove('assistant.target_app_dir');
        if ($this->seededId !== null) {
            $id = CassetteId::fromRaw($this->seededId);
            (new FileCassetteStore(Config::getString('replay.store.path')))->delete($id);
            (new FileCassetteStore(Config::getString('replay.local_path')))->delete($id);
            $this->seededId = null;
        }
        $testFile = dirname(__DIR__, 4) . '/app/tests/Replay/ReplayETT_AAATest.php';
        $cassetteFile = dirname(__DIR__, 4) . '/app/tests/Replay/cassettes/ETT-AAA.qcast';
        @unlink($testFile);
        @unlink($cassetteFile);
        @rmdir(dirname($cassetteFile));
        @rmdir(dirname($testFile));
    }

    #[Test]
    public function emitsAtestThroughTheRealSubprocess(): void
    {
        $store = new FileCassetteStore(Config::getString('replay.store.path'));
        $cassette = new Cassette(
            schemaVersion: CassetteCodec::CURRENT_SCHEMA_VERSION,
            meta: ['id' => 'ETT-AAA'],
            request: ['method' => 'GET', 'uri' => '/', 'headers' => [], 'cookies' => [], 'body' => ['encoding' => 'utf8', 'content' => '', 'truncated' => false], 'server' => []],
            resolved: [],
            session: null,
            user: null,
            effects: [],
            response: ['status' => 200],
            exception: null,
            log: null,
        );
        $store->put(CassetteId::fromRaw('ETT-AAA'), $cassette);
        $this->seededId = 'ETT-AAA';

        $tool = new EmitReplayTestTool(new TargetAppIntrospector());
        $result = $tool->emit('ETT-AAA');

        self::assertSame('ETT-AAA', $result['id']);
        self::assertIsString($result['test']);
        self::assertFileExists($result['test']);
    }
}
