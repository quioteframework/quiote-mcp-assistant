<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Integration\Mcp\Introspection\Capabilities;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Quiote\Config\Config;
use Quiote\Replay\Cassette\Cassette;
use Quiote\Replay\Cassette\CassetteCodec;
use Quiote\Replay\Cassette\CassetteId;
use Quiote\Replay\Store\FileCassetteStore;
use QuioteMcpAssistant\Mcp\Introspection\Capabilities\DescribeCassette;
use RuntimeException;

final class DescribeCassetteTest extends TestCase
{
    private ?string $seededId = null;

    protected function tearDown(): void
    {
        if ($this->seededId !== null) {
            $id = CassetteId::fromRaw($this->seededId);
            (new FileCassetteStore(Config::getString('replay.store.path')))->delete($id);
            // A successful resolve() write-caches into replay.local_path too.
            (new FileCassetteStore(Config::getString('replay.local_path')))->delete($id);
            $this->seededId = null;
        }
        parent::tearDown();
    }

    private function seed(string $rawId): void
    {
        $store = new FileCassetteStore(Config::getString('replay.store.path'));
        $cassette = new Cassette(
            schemaVersion: CassetteCodec::CURRENT_SCHEMA_VERSION,
            meta: ['id' => $rawId],
            request: ['method' => 'GET', 'uri' => '/'],
            resolved: ['route' => 'test.route'],
            session: null,
            user: null,
            effects: [],
            response: ['status' => 200, 'headers' => [], 'body' => ['encoding' => 'utf8', 'content' => 'hello', 'truncated' => false]],
            exception: null,
            log: null,
        );
        $store->put(CassetteId::fromRaw($rawId), $cassette);
        $this->seededId = $rawId;
    }

    #[Test]
    public function returnsTheFullProjectionWithExcerptedBodyByDefault(): void
    {
        $this->seed('DC-FULL');

        $result = DescribeCassette::run('web', 'DC-FULL');

        self::assertSame('DC-FULL', $result['id']);
        $source = $result['source'];
        self::assertIsString($source);
        self::assertStringContainsString('the configured store', $source);
        self::assertArrayHasKey('response', $result);
        $response = $result['response'];
        self::assertIsArray($response);
        $body = $response['body'];
        self::assertIsArray($body);
        self::assertArrayNotHasKey('content', $body);
        self::assertSame(5, $body['length']);
    }

    #[Test]
    public function includeBodiesReturnsFullContent(): void
    {
        $this->seed('DC-INCLUDE');

        $result = DescribeCassette::run('web', 'DC-INCLUDE', includeBodies: true);

        $response = $result['response'];
        self::assertIsArray($response);
        $body = $response['body'];
        self::assertIsArray($body);
        self::assertSame('hello', $body['content']);
    }

    #[Test]
    public function sectionNarrowsToOneKey(): void
    {
        $this->seed('DC-SECTION');

        $result = DescribeCassette::run('web', 'DC-SECTION', section: 'resolved');

        self::assertArrayHasKey('resolved', $result);
        self::assertArrayNotHasKey('response', $result);
        self::assertSame(['route' => 'test.route'], $result['resolved']);
    }

    #[Test]
    public function unknownSectionThrows(): void
    {
        $this->seed('DC-BADSECTION');

        $this->expectException(InvalidArgumentException::class);
        DescribeCassette::run('web', 'DC-BADSECTION', section: 'not-a-real-section');
    }

    #[Test]
    public function unresolvableIdThrows(): void
    {
        $this->expectException(RuntimeException::class);
        DescribeCassette::run('web', 'does-not-exist-either');
    }
}
