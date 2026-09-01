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
use QuioteMcpAssistant\Mcp\Tools\ReplayCassetteTool;

/**
 * Replay is isolated by default -- it performs nothing and is gated on nothing -- so the subprocess
 * re-bootstrapping the target app's own Config/settings.php fresh each time is enough to run a real
 * replay end to end: this covers the whole passthrough round-trip, cassette in and drift report out,
 * plus the `{"error": "..."}` shape a failure inside the subprocess comes back as.
 */
final class ReplayCassetteToolTest extends TestCase
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
    }

    #[Test]
    public function replaysThroughTheSubprocessAndReturnsTheDriftReport(): void
    {
        $store = new FileCassetteStore(Config::getString('replay.store.path'));
        $cassette = new Cassette(
            schemaVersion: CassetteCodec::CURRENT_SCHEMA_VERSION,
            meta: ['id' => 'RCT-AAA', 'context' => 'web'],
            request: ['method' => 'GET', 'uri' => '/', 'headers' => [], 'cookies' => [], 'body' => ['encoding' => 'utf8', 'content' => '', 'truncated' => false], 'server' => []],
            resolved: [],
            session: null,
            user: null,
            effects: [],
            response: ['status' => 200],
            exception: null,
            log: null,
        );
        $store->put(CassetteId::fromRaw('RCT-AAA'), $cassette);
        $this->seededId = 'RCT-AAA';

        $tool = new ReplayCassetteTool(new TargetAppIntrospector());
        $result = $tool->replay('RCT-AAA');

        self::assertArrayNotHasKey('error', $result);
        self::assertSame('RCT-AAA', $result['id']);
        self::assertIsString($result['source']);
        self::assertSame(200, $result['replayed_status']);
        self::assertSame(200, $result['recorded_status']);
        self::assertTrue($result['clean']);
        self::assertSame([], $result['diagnostics']);
    }

    #[Test]
    public function failureInsideTheSubprocessSurfacesAsTheStandardErrorShape(): void
    {
        $tool = new ReplayCassetteTool(new TargetAppIntrospector());
        $result = $tool->replay('RCT-NOSUCHCASSETTE');

        self::assertArrayHasKey('error', $result);
        self::assertIsString($result['error']);
        self::assertStringContainsString('RCT-NOSUCHCASSETTE', $result['error']);
    }
}
