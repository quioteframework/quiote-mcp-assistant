<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Introspection\Capabilities;

use Quiote\Context;
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
        if ($since !== null && $since !== '') {
            $rows = array_values(array_filter($rows, static fn(array $row): bool => $row['recorded_at'] !== null && $row['recorded_at'] >= $since));
        }
        usort($rows, static fn(array $a, array $b): int => ($b['recorded_at'] ?? '') <=> ($a['recorded_at'] ?? ''));
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
