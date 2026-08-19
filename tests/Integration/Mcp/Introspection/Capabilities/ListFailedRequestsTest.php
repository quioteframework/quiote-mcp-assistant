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
use QuioteMcpAssistant\Mcp\Introspection\Capabilities\ListFailedRequests;

/**
 * Integration, not unit: writes real fixture cassettes into this app's own configured store
 * (replay.store.path, see tests/bootstrap.php) and reads them back through the live,
 * bootstrapped `web` context -- see ListRoutesTest's own docblock for why this app dogfoods
 * itself as the introspection target rather than a fake.
 */
final class ListFailedRequestsTest extends TestCase
{
    /** @var list<string> */
    private array $seededIds = [];

    protected function tearDown(): void
    {
        $store = new FileCassetteStore(Config::getString('replay.store.path'));
        foreach ($this->seededIds as $id) {
            $store->delete(CassetteId::fromRaw($id));
        }
        $this->seededIds = [];
        parent::tearDown();
    }

    private function seed(string $rawId, int $status, ?string $trigger, string $recordedAt): void
    {
        $store = new FileCassetteStore(Config::getString('replay.store.path'));
        $cassette = new Cassette(
            schemaVersion: CassetteCodec::CURRENT_SCHEMA_VERSION,
            meta: ['id' => $rawId, 'recorded_at' => $recordedAt, 'trigger' => $trigger],
            request: [],
            resolved: ['route' => 'test.route'],
            session: null,
            user: null,
            effects: [],
            response: ['status' => $status],
            exception: null,
            log: null,
        );
        $store->put(CassetteId::fromRaw($rawId), $cassette);
        $this->seededIds[] = $rawId;
    }

    #[Test]
    public function returnsOnlyFailuresByDefault(): void
    {
        $this->seed('LFR-FAIL-1', 500, null, '2026-01-01T00:00:00+00:00');
        $this->seed('LFR-OK-1', 200, null, '2026-01-01T00:00:00+00:00');

        $result = ListFailedRequests::run('web');

        $ids = array_column($result['requests'], 'id');
        self::assertContains('LFR-FAIL-1', $ids);
        self::assertNotContains('LFR-OK-1', $ids);
    }

    #[Test]
    public function includesAnExplicitErrorTriggerEvenWithA2xxStatus(): void
    {
        $this->seed('LFR-ERR-TRIGGER', 200, 'error', '2026-01-01T00:00:00+00:00');

        $result = ListFailedRequests::run('web');

        self::assertContains('LFR-ERR-TRIGGER', array_column($result['requests'], 'id'));
    }

    #[Test]
    public function ordersNewestFirst(): void
    {
        $this->seed('LFR-OLD', 500, null, '2026-01-01T00:00:00+00:00');
        $this->seed('LFR-NEW', 500, null, '2026-06-01T00:00:00+00:00');

        $result = ListFailedRequests::run('web');

        $ids = array_column($result['requests'], 'id');
        self::assertLessThan(array_search('LFR-OLD', $ids, true), array_search('LFR-NEW', $ids, true));
    }

    #[Test]
    public function sinceFilterExcludesOlderFailures(): void
    {
        $this->seed('LFR-SINCE-OLD', 500, null, '2026-01-01T00:00:00+00:00');
        $this->seed('LFR-SINCE-NEW', 500, null, '2026-06-01T00:00:00+00:00');

        $result = ListFailedRequests::run('web', since: '2026-03-01T00:00:00+00:00');

        $ids = array_column($result['requests'], 'id');
        self::assertContains('LFR-SINCE-NEW', $ids);
        self::assertNotContains('LFR-SINCE-OLD', $ids);
    }

    #[Test]
    public function limitCapsTheResultCount(): void
    {
        $this->seed('LFR-LIMIT-1', 500, null, '2026-01-01T00:00:00+00:00');
        $this->seed('LFR-LIMIT-2', 500, null, '2026-01-02T00:00:00+00:00');
        $this->seed('LFR-LIMIT-3', 500, null, '2026-01-03T00:00:00+00:00');

        $result = ListFailedRequests::run('web', limit: 1);

        self::assertCount(1, $result['requests']);
        self::assertSame(1, $result['_schema_version']);
    }
}
