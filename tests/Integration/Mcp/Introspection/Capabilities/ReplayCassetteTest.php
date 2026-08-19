<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Integration\Mcp\Introspection\Capabilities;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Quiote\Config\Config;
use Quiote\Replay\Cassette\Cassette;
use Quiote\Replay\Cassette\CassetteCodec;
use Quiote\Replay\Cassette\CassetteId;
use Quiote\Replay\Replay\ReplayException;
use Quiote\Replay\Store\FileCassetteStore;
use QuioteMcpAssistant\Mcp\Introspection\Capabilities\ReplayCassette;
use RuntimeException;

final class ReplayCassetteTest extends TestCase
{
    private ?string $seededId = null;
    private ?bool $originalAllowLive = null;

    protected function setUp(): void
    {
        parent::setUp();
        $this->originalAllowLive = Config::has('replay.allow_live') ? Config::getBool('replay.allow_live') : null;
    }

    protected function tearDown(): void
    {
        if ($this->seededId !== null) {
            $id = CassetteId::fromRaw($this->seededId);
            (new FileCassetteStore(Config::getString('replay.store.path')))->delete($id);
            (new FileCassetteStore(Config::getString('replay.local_path')))->delete($id);
            $this->seededId = null;
        }
        if ($this->originalAllowLive !== null) {
            Config::set('replay.allow_live', $this->originalAllowLive, true, false);
        } else {
            Config::remove('replay.allow_live');
        }
        parent::tearDown();
    }

    private function seed(string $rawId, string $method = 'GET', int $status = 999): void
    {
        $store = new FileCassetteStore(Config::getString('replay.store.path'));
        $cassette = new Cassette(
            schemaVersion: CassetteCodec::CURRENT_SCHEMA_VERSION,
            meta: ['id' => $rawId, 'context' => 'web'],
            request: ['method' => $method, 'uri' => '/', 'headers' => [], 'cookies' => [], 'body' => ['encoding' => 'utf8', 'content' => '', 'truncated' => false], 'server' => []],
            resolved: [],
            session: null,
            user: null,
            effects: [],
            response: ['status' => $status, 'headers' => [], 'body' => ['encoding' => 'utf8', 'content' => 'deliberately-wrong', 'truncated' => false]],
            exception: null,
            log: null,
        );
        $store->put(CassetteId::fromRaw($rawId), $cassette);
        $this->seededId = $rawId;
    }

    #[Test]
    public function refusesToRunWhenAllowLiveIsFalse(): void
    {
        Config::set('replay.allow_live', false, true, false);
        $this->seed('RC-NOTALLOWED');

        $this->expectException(ReplayException::class);
        ReplayCassette::run('web', 'RC-NOTALLOWED');
    }

    #[Test]
    public function reportsDriftAgainstADeliberatelyWrongRecordedStatus(): void
    {
        Config::set('replay.allow_live', true, true, false);
        $this->seed('RC-DRIFT', status: 999);

        $result = ReplayCassette::run('web', 'RC-DRIFT');

        self::assertSame('RC-DRIFT', $result['id']);
        self::assertIsInt($result['replayed_status']);
        self::assertSame(999, $result['recorded_status']);
        self::assertFalse($result['clean']);
        self::assertNotEmpty($result['diagnostics']);
    }

    #[Test]
    public function unresolvableIdThrows(): void
    {
        Config::set('replay.allow_live', true, true, false);

        $this->expectException(RuntimeException::class);
        ReplayCassette::run('web', 'does-not-exist-either');
    }
}
