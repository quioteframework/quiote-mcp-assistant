<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Unit\Mcp\Search;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use QuioteMcpAssistant\Mcp\Resources\DocLibrary;
use QuioteMcpAssistant\Mcp\Search\DocIndex;

/**
 * DocLibrary is final and reads from this package's own bundled docs, so
 * these tests run against the real corpus rather than a fixture double --
 * the same tradeoff `tools/mcp-smoke-client.php` already accepts for its
 * own ranking assertions. That's an intentional, not incidental, choice:
 * the regression this class exists to guard against (see its own docblock)
 * is entirely about how real documentation content ranks against real
 * queries, so testing against synthetic fixtures would risk missing the
 * exact failure mode it was built to fix.
 */
final class DocIndexTest extends TestCase
{
    private DocIndex $index;

    protected function setUp(): void
    {
        $this->index = new DocIndex(new DocLibrary());
    }

    #[Test]
    public function ranksTheDocMostSpecificallyAboutTheQueryFirst(): void
    {
        $results = $this->index->search('how do I add a plugin');

        self::assertNotEmpty($results);
        self::assertSame('quiote-docs://architecture/plugins', $results[0]['uri']);
    }

    #[Test]
    public function doesNotLetBodyRepetitionOutrankATitleMatch(): void
    {
        // The regression this class was rewritten to fix: "server" appearing
        // many times inside an unrelated doc's prose/identifiers (e.g.
        // ServerRequestInterface) must not outrank a doc whose title/heading
        // is actually about the query.
        $results = $this->index->search('database connection');

        self::assertNotEmpty($results);
        self::assertSame('quiote-docs://basics/databases', $results[0]['uri']);
    }

    #[Test]
    public function wordBoundaryMatchingExcludesSubstringHits(): void
    {
        // "cli" must not match inside "client" -- searching for the CLI docs
        // specifically should surface the actual CLI doc, not just whatever
        // doc happens to say "client" the most.
        $results = $this->index->search('cli commands');

        self::assertNotEmpty($results);
        self::assertSame('quiote-docs://getting-started/cli', $results[0]['uri']);
    }

    #[Test]
    public function returnsNoResultsForAQueryMatchingNoTerms(): void
    {
        self::assertSame([], $this->index->search('xyznonexistentqueryterm'));
    }

    #[Test]
    public function returnsNoResultsForAQueryThatTokenizesToNothing(): void
    {
        // Punctuation-only/empty input has no word characters at all, so
        // tokenize() itself produces an empty term list -- a distinct
        // failure path from "terms found but nothing matched" above.
        self::assertSame([], $this->index->search(''));
        self::assertSame([], $this->index->search('???'));
    }

    #[Test]
    public function stillSearchesOnAQueryMadeUpEntirelyOfStopwords(): void
    {
        // "how do I" tokenizes to only stopwords; falling back to searching
        // on them anyway is better than returning nothing.
        $results = $this->index->search('how do I');

        self::assertNotEmpty($results);
    }

    #[Test]
    public function clampsTheLimitBetweenOneAndTwenty(): void
    {
        self::assertCount(1, $this->index->search('routing', 0));
        self::assertLessThanOrEqual(20, count($this->index->search('routing', 500)));
    }

    #[Test]
    public function everyResultHasAQueryCenteredExcerpt(): void
    {
        $results = $this->index->search('routing');

        self::assertNotEmpty($results);
        foreach ($results as $result) {
            self::assertNotSame('', $result['excerpt']);
        }
    }
}
