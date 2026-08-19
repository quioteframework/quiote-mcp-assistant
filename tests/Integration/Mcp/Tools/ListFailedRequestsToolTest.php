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
use QuioteMcpAssistant\Mcp\Tools\ListFailedRequestsTool;

final class ListFailedRequestsToolTest extends TestCase
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
            (new FileCassetteStore(Config::getString('replay.store.path')))->delete(CassetteId::fromRaw($this->seededId));
            $this->seededId = null;
        }
    }

    private function seed(string $rawId): void
    {
        $store = new FileCassetteStore(Config::getString('replay.store.path'));
        $cassette = new Cassette(
            schemaVersion: CassetteCodec::CURRENT_SCHEMA_VERSION,
            meta: ['id' => $rawId],
            request: [],
            resolved: [],
            session: null,
            user: null,
            effects: [],
            response: ['status' => 500],
            exception: null,
            log: null,
        );
        $store->put(CassetteId::fromRaw($rawId), $cassette);
        $this->seededId = $rawId;
    }

    #[Test]
    public function listsAFailureThroughTheRealSubprocess(): void
    {
        $this->seed('LFRT-FAIL');

        $tool = new ListFailedRequestsTool(new TargetAppIntrospector());
        $result = $tool->list();

        self::assertIsArray($result['requests']);
        self::assertContains('LFRT-FAIL', array_column($result['requests'], 'id'));
    }
}
