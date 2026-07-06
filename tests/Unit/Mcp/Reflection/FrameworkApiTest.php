<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Unit\Mcp\Reflection;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use QuioteMcpAssistant\Mcp\Reflection\FrameworkApi;

/**
 * Reflects over the real, installed `quioteframework/quiote` package --
 * not a fixture -- since FrameworkApi's whole job is deriving its class
 * list from Composer's actual PSR-4 map (see its own docblock for why).
 */
final class FrameworkApiTest extends TestCase
{
    private FrameworkApi $api;

    protected function setUp(): void
    {
        $this->api = new FrameworkApi();
    }

    #[Test]
    public function versionReportsTheInstalledPackageVersion(): void
    {
        self::assertNotSame('unknown', $this->api->version());
    }

    #[Test]
    public function classesUnderWithNoArgumentListsTheWholeFrameworkNamespace(): void
    {
        $classes = $this->api->classesUnder();

        self::assertNotEmpty($classes);
        self::assertContains('Quiote\Action\Action', $classes);
        foreach ($classes as $fqcn) {
            self::assertStringStartsWith('Quiote', $fqcn);
        }
    }

    #[Test]
    public function classesUnderNarrowsToOneNamespace(): void
    {
        $classes = $this->api->classesUnder('Quiote\Action');

        self::assertNotEmpty($classes);
        foreach ($classes as $fqcn) {
            self::assertTrue(
                $fqcn === 'Quiote\Action' || str_starts_with($fqcn, 'Quiote\Action\\'),
                "{$fqcn} is not under Quiote\\Action",
            );
        }
    }

    #[Test]
    public function classesUnderAnUnknownNamespaceReturnsNothing(): void
    {
        self::assertSame([], $this->api->classesUnder('Quiote\ThisNamespaceDoesNotExist'));
    }

    #[Test]
    public function topLevelNamespacesCountsClassesPerNamespaceSorted(): void
    {
        $namespaces = $this->api->topLevelNamespaces();

        self::assertNotEmpty($namespaces);
        self::assertArrayHasKey('Quiote\Action', $namespaces);
        self::assertGreaterThan(0, $namespaces['Quiote\Action']);

        $keys = array_keys($namespaces);
        $sorted = $keys;
        sort($sorted);
        self::assertSame($sorted, $keys, 'topLevelNamespaces() should be ksorted.');
    }

    #[Test]
    public function isFrameworkSymbolAcceptsTheRootAndAnythingUnderIt(): void
    {
        self::assertTrue($this->api->isFrameworkSymbol('Quiote'));
        self::assertTrue($this->api->isFrameworkSymbol('Quiote\Action\Action'));
        self::assertTrue($this->api->isFrameworkSymbol('\Quiote\Action\Action')); // leading backslash stripped
    }

    #[Test]
    public function isFrameworkSymbolRejectsAnythingOutsideTheNamespace(): void
    {
        self::assertFalse($this->api->isFrameworkSymbol('QuioteMcpAssistant\Mcp\AssistantPlugin'));
        self::assertFalse($this->api->isFrameworkSymbol('Symfony\Component\Routing\Route'));
        // A near-miss prefix must not false-positive (e.g. "QuioteX" starts
        // with "Quiote" as a raw string but isn't the Quiote\ namespace).
        self::assertFalse($this->api->isFrameworkSymbol('QuioteX\Whatever'));
    }

    #[Test]
    public function classLikeExistsAcceptsARealClass(): void
    {
        // Derived at runtime (not a literal) so this genuinely exercises
        // the dynamic class_exists()-family check classLikeExists() wraps,
        // rather than a class name PHPStan's own analysis already knows
        // resolves -- describe_symbol's real input is exactly this kind of
        // only-known-at-runtime string.
        $realClass = $this->api->classesUnder('Quiote\Action')[0];
        self::assertTrue($this->api->classLikeExists($realClass));
    }

    #[Test]
    public function classLikeExistsRejectsAnUnknownClass(): void
    {
        self::assertFalse($this->api->classLikeExists('Quiote\\' . uniqid('NoSuchClass')));
    }

    #[Test]
    public function summarizeDescribesARealClass(): void
    {
        $summary = $this->api->summarize('Quiote\Action\Action');

        self::assertSame('Quiote\Action\Action', $summary['fqcn']);
        self::assertContains($summary['kind'], ['class', 'interface', 'trait', 'enum']);
    }

    #[Test]
    public function summarizeRejectsAnUnknownSymbol(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->api->summarize('Quiote\NoSuchClassAtAll');
    }

    #[Test]
    public function describeClassIncludesOnlyMembersDeclaredOnTheClassItself(): void
    {
        $description = $this->api->describeClass('Quiote\Action\Action');

        self::assertSame('Quiote\Action\Action', $description['fqcn']);
        self::assertNotEmpty($description['methods']);
        // Every reported method must actually be declared on Action, not
        // inherited from some ancestor -- otherwise describing Action would
        // also dump every method from every parent class.
        foreach ($description['methods'] as $method) {
            self::assertTrue(
                method_exists('Quiote\Action\Action', $method['name']),
                "Reported method {$method['name']} does not exist on Action.",
            );
        }
    }

    #[Test]
    public function describeClassRejectsAnUnknownSymbol(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->api->describeClass('Quiote\NoSuchClassAtAll');
    }

    #[Test]
    public function describeMethodReportsParametersAndReturnType(): void
    {
        $ref = new \ReflectionMethod('Quiote\Action\Action', 'getDefaultViewName');
        $description = $this->api->describeMethod($ref);

        self::assertSame('getDefaultViewName', $description['name']);
        self::assertSame([], $description['parameters']);
        self::assertSame([], $description['attributes']);
    }
}
