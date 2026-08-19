<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Introspection\Capabilities;

use Quiote\Config\Config;
use Quiote\Context;
use Quiote\Replay\Cassette\Cassette;
use Quiote\Replay\Cassette\CassetteId;
use Quiote\Replay\Index\CassetteIndexChain;
use Quiote\Replay\Index\CassetteIndexException;
use Quiote\Replay\Index\CassetteIndexRegistry;
use Quiote\Replay\Index\IndexHints;
use Quiote\Replay\Store\CassetteStoreInterface;
use Quiote\Replay\Store\FileCassetteStore;
use RuntimeException;

/**
 * The same three-tier lookup `quiote cassette:fetch`/`quiote replay --save` perform -- the local
 * cache, then whichever store `replay.store` names, then the cassette-index chain given a
 * `key`/`date`/`hour` hint -- reimplemented here rather than reused from
 * `Quiote\Replay\Console\ResolvesCassetteViaIndexes` because that trait reports failure through a
 * `SymfonyStyle`, which has no meaning for a capability that reports failure by throwing (probe.php
 * turns any thrown exception into the standard `{"error": "..."}` shape).
 *
 * Reimplementing it does mean the two can drift, and they had: the trait learned to try an explicit
 * `key` before the configured store, and to explain a chain that resolved nothing, and this copy did
 * not. Both are matched below, and anything further should probably be pushed down into the
 * framework rather than fixed twice again.
 */
final class CassetteResolution
{
    /**
     * @return array{cassette: Cassette, source: string, cached_path: ?string}
     * @throws RuntimeException if no tier can produce the cassette.
     */
    public static function resolve(string $contextName, string $rawId, ?string $key = null, ?string $date = null, ?string $hour = null): array
    {
        $id = CassetteId::fromRaw($rawId);
        $hints = new IndexHints($key, $date, $hour);

        $localStore = new FileCassetteStore(self::localCacheDirectory());
        $cassette = $localStore->get($id);
        if ($cassette !== null) {
            return ['cassette' => $cassette, 'source' => 'the local cache', 'cached_path' => null];
        }

        $container = Context::getInstance($contextName)->getContainer();

        // An exact key goes straight to the index chain, matching what `--key` documents itself as
        // doing. Asking the configured store first means an object store walks its whole lookback
        // window with one request per hour before reaching a key the caller already supplied.
        if ($key !== null && $key !== '') {
            return self::cached($localStore, $id, self::viaIndexChain($container, $id, $hints), 'the explicit key');
        }

        $configuredStore = $container->get(CassetteStoreInterface::class);
        $cassette = $configuredStore->get($id);
        if ($cassette !== null) {
            $source = sprintf('the configured store ("replay.store" = "%s")', Config::getString('replay.store', 'file'));

            return self::cached($localStore, $id, $cassette, $source);
        }

        return self::cached($localStore, $id, self::viaIndexChain($container, $id, $hints), 'cassette index resolution');
    }

    /**
     * @throws RuntimeException with the chain's own reasons, plus what a caller can do about it.
     */
    private static function viaIndexChain(\Quiote\DI\Container $container, CassetteId $id, IndexHints $hints): Cassette
    {
        try {
            return CassetteIndexChain::resolve(CassetteIndexRegistry::build($container), $id, $hints);
        } catch (CassetteIndexException $e) {
            // The chain's message names each index's failure, which is the useful half. The other
            // half -- what to pass next -- is only knowable here, where the hints are.
            throw new RuntimeException(sprintf(
                '%s%s',
                $e->getMessage(),
                $hints->key === null && $hints->date === null
                    ? ' Pass a "date" (YYYY-MM-DD) or an exact "key" from the recorder\'s pointer log line: without'
                        . ' either, only a cassette inside the store\'s own lookback window can be found, or one a'
                        . ' Log Analytics workspace can point at.'
                    : '',
            ), 0, $e);
        }
    }

    /**
     * Writes the resolved cassette into the local cache, so a second tool call on the same id needs
     * no network at all.
     *
     * @return array{cassette: Cassette, source: string, cached_path: ?string}
     */
    private static function cached(FileCassetteStore $localStore, CassetteId $id, Cassette $cassette, string $source): array
    {
        $localStore->put($id, $cassette);

        return [
            'cassette' => $cassette,
            'source' => $source,
            'cached_path' => rtrim(self::localCacheDirectory(), '/\\') . '/' . $id->slug . '.qcast',
        ];
    }

    private static function localCacheDirectory(): string
    {
        return Config::getString('replay.local_path', 'var/cassettes');
    }
}
