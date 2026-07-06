<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Search;

use QuioteMcpAssistant\Mcp\Resources\DocLibrary;

/**
 * Documentation search: a deliberately simple, dependency-free full-text
 * ranker over the bundled docs -- no persistent search index.
 *
 * Scoring per doc, summed over the query's terms:
 *   title occurrence        × 20   (frontmatter title -- the strongest signal)
 *   description occurrence  × 15   (frontmatter description -- a close second)
 *   heading occurrence       × 8   (Markdown `#`/`##`/… lines)
 *   body occurrence          × 1   (prose/code, capped -- see below)
 *
 * Two corrections keep body-term frequency from swamping the title/heading/
 * description signal, which an earlier version was prone to (a query like
 * "MCP server" ranked an unrelated middleware doc first purely because it
 * happened to mention "server" -- inside identifiers like
 * `ServerRequestInterface`, via unbounded substring counting -- ten times):
 *
 * 1. **Word-boundary matching**, not substring counting, so "server" doesn't
 *    match inside "ServerRequestInterface", nor "cli" inside "client".
 * 2. **Per-field occurrence caps** (diminishing returns past a few hits) and
 *    **IDF down-weighting** (a term that appears in most of the corpus, e.g.
 *    "server" or "config", carries far less discriminating power than one
 *    that appears in a handful of docs, e.g. "validator") -- both applied
 *    before the tier weights above, so one doc's raw repetition of a common
 *    word can no longer outrank a doc whose *title or heading* is actually
 *    about the query.
 *
 * A coverage factor also discounts docs that only match a minority of the
 * query's distinct terms, so multi-term queries prefer docs relevant to the
 * whole query over docs that happen to repeat one common term.
 *
 * Docs matching no term are dropped; the rest are returned highest-first with
 * a query-centered excerpt for citation.
 */
final class DocIndex
{
    private const WEIGHT_TITLE = 20;
    private const WEIGHT_DESCRIPTION = 15;
    private const WEIGHT_HEADING = 8;
    private const WEIGHT_BODY = 1;

    private const CAP_TITLE = 3;
    private const CAP_DESCRIPTION = 3;
    private const CAP_HEADING = 5;
    private const CAP_BODY = 4;

    /** Common words that carry little signal on their own; ignored unless a query is made up entirely of them. */
    private const STOPWORDS = [
        'a', 'an', 'the', 'of', 'to', 'in', 'on', 'for', 'and', 'or', 'is', 'are', 'be',
        'how', 'do', 'does', 'i', 'you', 'it', 'with', 'as', 'this', 'that', 'my', 'your',
    ];

    public function __construct(private readonly DocLibrary $library) {}

    /**
     * @return list<array{uri: string, title: string, score: float, excerpt: string}>
     */
    public function search(string $query, int $limit = 5): array
    {
        $terms = $this->tokenize($query);
        if ($terms === []) {
            return [];
        }

        $limit = max(1, min(20, $limit));

        /** @var array<string, array{title: string, description: string, headings: string, body: string}> $fields */
        $fields = [];
        foreach ($this->library->manifest() as $uri => $meta) {
            $body = $this->library->body($uri);
            if ($body === null) {
                continue;
            }
            $fields[$uri] = [
                'title' => $meta['title'],
                'description' => $meta['description'],
                'headings' => implode("\n", $this->headings($body)),
                'body' => $body,
            ];
        }

        $idf = $this->inverseDocumentFrequencies($terms, $fields);

        $results = [];
        foreach ($fields as $uri => $field) {
            $matchedTerms = 0;
            $score = 0.0;

            foreach ($terms as $term) {
                $titleHits = min($this->countWord($term, $field['title']), self::CAP_TITLE);
                $descHits = min($this->countWord($term, $field['description']), self::CAP_DESCRIPTION);
                $headingHits = min($this->countWord($term, $field['headings']), self::CAP_HEADING);
                $bodyHits = min($this->countWord($term, $field['body']), self::CAP_BODY);

                if ($titleHits + $descHits + $headingHits + $bodyHits === 0) {
                    continue;
                }

                ++$matchedTerms;
                $score += $idf[$term] * (
                    $titleHits * self::WEIGHT_TITLE
                    + $descHits * self::WEIGHT_DESCRIPTION
                    + $headingHits * self::WEIGHT_HEADING
                    + $bodyHits * self::WEIGHT_BODY
                );
            }

            if ($matchedTerms === 0) {
                continue;
            }

            // Docs covering more of the query's distinct terms outrank docs
            // repeating just one of them -- full coverage keeps full score,
            // matching only a minority is discounted but not zeroed.
            $coverage = $matchedTerms / count($terms);
            $score *= 0.5 + 0.5 * $coverage;

            $results[$uri] = [
                'uri' => $uri,
                'title' => $field['title'],
                'score' => round($score, 2),
                'excerpt' => $this->excerpt($field['body'], $terms),
            ];
        }

        usort($results, static fn (array $a, array $b) => $b['score'] <=> $a['score'] ?: strcmp($a['uri'], $b['uri']));

        return array_slice($results, 0, $limit);
    }

    /**
     * Smoothed IDF per term over the doc set being searched: log((N+1)/(df+1)) + 1,
     * always ≥ 1 (never zeroes a term out), shrinking toward 1 as a term appears
     * in more of the corpus.
     *
     * @param list<string> $terms
     * @param array<string, array{title: string, description: string, headings: string, body: string}> $fields
     * @return array<string, float>
     */
    private function inverseDocumentFrequencies(array $terms, array $fields): array
    {
        $total = count($fields);
        $idf = [];

        foreach ($terms as $term) {
            $df = 0;
            foreach ($fields as $field) {
                $haystack = $field['title'] . "\n" . $field['description'] . "\n" . $field['headings'] . "\n" . $field['body'];
                if ($this->countWord($term, $haystack) > 0) {
                    ++$df;
                }
            }
            $idf[$term] = log(($total + 1) / ($df + 1)) + 1;
        }

        return $idf;
    }

    /**
     * Case-insensitive, word-boundary occurrence count of $term in $haystack
     * (a trailing "s" is tolerated so "route" also matches "routes"). Avoids
     * matching a short/common term inside an unrelated longer identifier
     * (e.g. "server" inside "ServerRequestInterface", "cli" inside "client").
     */
    private function countWord(string $term, string $haystack): int
    {
        if ($term === '' || $haystack === '') {
            return 0;
        }

        $pattern = '/(?<![\p{L}\p{N}_])' . preg_quote($term, '/') . 's?(?![\p{L}\p{N}_])/iu';

        return preg_match_all($pattern, $haystack) ?: 0;
    }

    /** @return list<string> */
    private function tokenize(string $query): array
    {
        preg_match_all('/[\p{L}\p{N}_#\[\]\\\\]+/u', strtolower($query), $m);
        $terms = array_values(array_unique(array_filter($m[0], static fn (string $t) => strlen($t) >= 2)));

        $meaningful = array_values(array_diff($terms, self::STOPWORDS));

        // A query made up entirely of stopwords (e.g. "how do I") should still
        // search on something rather than return nothing.
        return $meaningful !== [] ? $meaningful : $terms;
    }

    /** @return list<string> */
    private function headings(string $body): array
    {
        preg_match_all('/^#{1,6}\s+(.*)$/m', $body, $m);
        return $m[1];
    }

    /**
     * A ~320-character window centered on the first matched term, cleaned of
     * Markdown noise, so the caller can show why a doc matched.
     *
     * The docs contain multi-byte UTF-8 (em dashes, box-drawing tree glyphs
     * in file-tree examples, …), so this must slice by *character*, not byte,
     * offset -- `substr()`/`strpos()` operate on bytes and can cut a
     * multi-byte character in half, producing malformed UTF-8 that then
     * fails `json_encode()` for the whole `tools/call` response (breaking
     * the call silently, with no error surfaced to the client).
     *
     * @param list<string> $terms
     */
    private function excerpt(string $body, array $terms): string
    {
        $bodyLc = mb_strtolower($body, 'UTF-8');
        $pos = false;
        foreach ($terms as $term) {
            $p = mb_strpos($bodyLc, $term, 0, 'UTF-8');
            if ($p !== false && ($pos === false || $p < $pos)) {
                $pos = $p;
            }
        }
        if ($pos === false) {
            $pos = 0;
        }

        $start = max(0, $pos - 120);
        $slice = mb_substr($body, $start, 320, 'UTF-8');
        $slice = preg_replace('/\s+/u', ' ', $slice) ?? $slice;
        $slice = trim($slice);

        return ($start > 0 ? '…' : '') . $slice . (mb_strlen($body, 'UTF-8') > $start + 320 ? '…' : '');
    }
}
