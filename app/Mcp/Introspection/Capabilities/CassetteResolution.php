<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Introspection\Capabilities;

use Quiote\Config\Config;
use Quiote\Context;
use Quiote\Replay\Cassette\Cassette;
use Quiote\Replay\Cassette\CassetteId;
use Quiote\Replay\Index\CassetteIndexChain;
use Quiote\Replay\Index\CassetteIndexRegistry;
use Quiote\Replay\Index\IndexHints;
use Quiote\Replay\Store\CassetteStoreInterface;
use Quiote\Replay\Store\FileCassetteStore;

/**
 * The same three-tier lookup `quiote cassette:fetch`/`quiote replay --save` perform -- the local
 * cache, then whichever store `replay.store` names, then the cassette-index chain given a
 * `key`/`date`/`hour` hint (or none at all, if the target app has a `log-analytics` index
 * configured) -- reimplemented here rather than reused from
 * `Quiote\Replay\Console\ResolvesCassetteViaIndexes` because that trait reports failure through a
 * `SymfonyStyle`, which has no meaning for a capability that reports failure by throwing (probe.php
 * turns any thrown exception into the standard `{"error": "..."}` shape).
 */
final class CassetteResolution
{
    /** @return array{cassette: Cassette, source: string, cached_path: ?string} */
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
        $configuredStore = $container->get(CassetteStoreInterface::class);
        $cassette = $configuredStore->get($id);
        $source = sprintf('the configured store ("replay.store" = "%s")', Config::getString('replay.store', 'file'));

        if ($cassette === null) {
            $cassette = CassetteIndexChain::resolve(CassetteIndexRegistry::build($container), $id, $hints);
            $source = 'cassette index resolution';
        }

        $localStore->put($id, $cassette);

        return ['cassette' => $cassette, 'source' => $source, 'cached_path' => rtrim(self::localCacheDirectory(), '/\\') . '/' . $id->slug . '.qcast'];
    }

    private static function localCacheDirectory(): string
    {
        return Config::getString('replay.local_path', 'var/cassettes');
    }
}
