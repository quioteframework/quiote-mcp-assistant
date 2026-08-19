<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Integration\Mcp\Introspection;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Quiote\Config\Config;
use QuioteMcpAssistant\Mcp\Introspection\CassetteIntrospector;
use QuioteMcpAssistant\Mcp\Introspection\TargetAppIntrospector;

/**
 * Which cassette store a cassette tool reads from.
 *
 * The distinction under test is not cosmetic: with no route configured, a tool must say so rather
 * than answer from this assistant's own empty `var/cassettes` -- "no cassettes found" for a
 * production id reads as an answer, and would send someone looking for a bug that is really a
 * missing `--cassette-store`.
 */
final class CassetteIntrospectorTest extends TestCase
{
    private ?string $originalTargetApp = null;
    private ?string $originalDirectStore = null;

    protected function setUp(): void
    {
        parent::setUp();
        $this->originalTargetApp = Config::getNullableString('assistant.target_app_dir');
        $this->originalDirectStore = Config::getNullableString('assistant.direct_cassette_store');
        Config::remove('assistant.target_app_dir');
        Config::remove('assistant.direct_cassette_store');
    }

    protected function tearDown(): void
    {
        Config::remove('assistant.target_app_dir');
        Config::remove('assistant.direct_cassette_store');
        if ($this->originalTargetApp !== null) {
            Config::set('assistant.target_app_dir', $this->originalTargetApp);
        }
        if ($this->originalDirectStore !== null) {
            Config::set('assistant.direct_cassette_store', $this->originalDirectStore);
        }
        parent::tearDown();
    }

    private function introspector(): CassetteIntrospector
    {
        return new CassetteIntrospector(new TargetAppIntrospector());
    }

    #[Test]
    public function withNeitherRouteConfiguredItReportsBothWaysToFixIt(): void
    {
        $result = $this->introspector()->run('describe_cassette', ['id' => 'SUX2020'], static fn(): array => ['ran' => true]);

        $this->assertArrayHasKey('error', $result);
        $error = $result['error'];
        $this->assertIsString($error);
        $this->assertStringContainsString('--target-app-dir', $error);
        $this->assertStringContainsString('--cassette-store=azure-blob', $error);
    }

    #[Test]
    public function withNeitherRouteConfiguredTheInProcessPathIsNotRun(): void
    {
        // The point of the guard: a store always resolves (ReplayPlugin registers a file store for
        // the `file` default), so without the marker this would have answered from this app's own
        // empty directory.
        $ran = false;
        $this->introspector()->run('describe_cassette', ['id' => 'SUX2020'], static function () use (&$ran): array {
            $ran = true;

            return [];
        });

        $this->assertFalse($ran);
    }

    #[Test]
    public function aDirectStoreRunsTheCapabilityInProcess(): void
    {
        Config::set('assistant.direct_cassette_store', '--cassette-store');

        $result = $this->introspector()->run('describe_cassette', ['id' => 'SUX2020'], static fn(string $ctx): array => ['ran_in_process' => true, 'context' => $ctx]);

        $this->assertTrue($result['ran_in_process']);
        $this->assertSame(Config::getString('core.default_context', 'web'), $result['context']);
    }

    #[Test]
    public function aTargetAppWinsOverADirectStore(): void
    {
        // A capability that can only be answered by one route (replaying, emitting a test) needs the
        // target app, and answering some tools from one store and some from another would be worse
        // than confusing. So when both are available the app wins, and the in-process path is unused.
        //
        // Pointed at a directory that does not exist on purpose: TargetAppIntrospector rejects that
        // before spawning anything, which proves the route was taken without this test bootstrapping
        // a second app in a subprocess (and leaving its cache directory behind).
        Config::set('assistant.target_app_dir', '/nonexistent/target/app');
        Config::set('assistant.direct_cassette_store', '--cassette-store');
        $ran = false;

        $result = $this->introspector()->run('describe_cassette', ['id' => 'SUX2020'], static function () use (&$ran): array {
            $ran = true;

            return [];
        });

        $this->assertFalse($ran, 'The target app route must be taken.');
        $error = $result['error'] ?? null;
        $this->assertIsString($error);
        $this->assertStringContainsString('does not exist', $error, 'and its own failure is what surfaces');
    }

    #[Test]
    public function anInProcessFailureIsReportedInTheSameErrorShapeAsTheProbe(): void
    {
        Config::set('assistant.direct_cassette_store', '--cassette-store');

        $result = $this->introspector()->run(
            'describe_cassette',
            ['id' => 'SUX2020'],
            static fn(): array => throw new \RuntimeException('no cassette found for "SUX2020"'),
        );

        $this->assertSame(['error' => 'no cassette found for "SUX2020"'], $result);
    }

    #[Test]
    public function hasTargetAppIgnoresAWhitespaceOnlyValue(): void
    {
        Config::set('assistant.target_app_dir', '   ');

        $this->assertFalse(CassetteIntrospector::hasTargetApp());
    }
}
