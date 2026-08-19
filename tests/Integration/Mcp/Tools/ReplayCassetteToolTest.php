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
 * The target app's own Config/settings.php leaves replay.allow_live at its false default (no live
 * traffic is ever recorded here) -- the subprocess re-bootstraps from that file fresh each time, so
 * this only exercises (and can only exercise) the refusal path; ReplayCassetteTest covers a real
 * replay in-process with allow_live overridden for the test.
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
    public function refusalSurfacesAsTheStandardErrorShape(): void
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

        self::assertArrayHasKey('error', $result);
        self::assertIsString($result['error']);
        self::assertStringContainsString('allow_live', $result['error']);
    }
}
