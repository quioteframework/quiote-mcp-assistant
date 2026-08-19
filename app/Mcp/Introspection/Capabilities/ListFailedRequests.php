<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Introspection\Capabilities;

use Quiote\Context;
use Quiote\Replay\Cassette\RecordedAt;
use Quiote\Replay\Console\CollectsCassetteRows;
use Quiote\Replay\Store\CassetteStoreInterface;
use Quiote\Replay\Store\ListableCassetteStoreInterface;
use Quiote\Support\Compiler\Diagnostic;
use RuntimeException;

/**
 * `list_failed_requests(since?, limit?)` -- candidate ids for "what broke": every cassette in the
 * target app's configured store whose response was a 5xx, or whose recorder trigger was `error`,
 * newest first. The entry point for the "Quiote request X failed in production, analyze it"
 * workflow -- `describe_cassette` on whichever id looks relevant is the next step.
 */
final class ListFailedRequests
{
    use CollectsCassetteRows;

    /**
     * @return array{
     *     _schema_version: int,
     *     count: int,
     *     requests: list<array{id: string, slug: string, recorded_at: ?string, route: ?string, status: ?int, trigger: ?string}>,
     *     diagnostics: list<array<string, mixed>>,
     * }
     */
    public static function run(string $contextName, ?string $since = null, ?int $limit = null): array
    {
        $store = Context::getInstance($contextName)->getContainer()->get(CassetteStoreInterface::class);
        if (!$store instanceof ListableCassetteStoreInterface) {
            throw new RuntimeException(sprintf('The configured cassette store (%s) cannot be listed.', $store::class));
        }

        [$rows, $diagnostics] = self::collectCassetteRows($store);

        $rows = array_values(array_filter($rows, static fn(array $row): bool => self::isFailure($row)));

        // Filtered and sorted by instant, not by string. `RecorderMiddleware` formats `recorded_at`
        // in PHP's default timezone rather than forcing UTC, so two cassettes recorded either side
        // of an offset difference compare wrong as strings even though both are valid ISO-8601 --
        // and `RecordedAt` additionally refuses a relative expression, which `recorded_at` should
        // never carry but is untrusted cassette content either way. `cassette:list` had exactly this
        // bug; this capability reimplements the filter rather than sharing the command's, so it did
        // not inherit the fix.
        if ($since !== null && $since !== '') {
            $sinceTimestamp = RecordedAt::timestamp($since);
            if ($sinceTimestamp === null) {
                throw new RuntimeException(sprintf('Could not parse "since" value "%s" as an ISO-8601 timestamp.', $since));
            }
            $rows = array_values(array_filter(
                $rows,
                static fn(array $row): bool => (RecordedAt::timestamp($row['recorded_at']) ?? null) !== null
                    && RecordedAt::timestamp($row['recorded_at']) >= $sinceTimestamp,
            ));
        }
        usort(
            $rows,
            static fn(array $a, array $b): int => (RecordedAt::timestamp($b['recorded_at']) ?? 0)
                <=> (RecordedAt::timestamp($a['recorded_at']) ?? 0),
        );
        if ($limit !== null && $limit > 0) {
            $rows = array_slice($rows, 0, $limit);
        }

        return [
            '_schema_version' => 1,
            'count' => count($rows),
            'requests' => $rows,
            'diagnostics' => array_map(static fn(Diagnostic $d): array => $d->toArray(), $diagnostics),
        ];
    }

    /** @param array{status: ?int, trigger: ?string} $row */
    private static function isFailure(array $row): bool
    {
        return ($row['status'] !== null && $row['status'] >= 500) || $row['trigger'] === 'error';
    }
}
