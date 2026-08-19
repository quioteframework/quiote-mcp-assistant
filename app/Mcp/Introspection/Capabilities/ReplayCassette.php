<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Introspection\Capabilities;

use Quiote\Context;
use Quiote\Replay\Replay\ReplayEngine;
use Quiote\Support\Compiler\Diagnostic;

/**
 * `replay_cassette(id, ...)` -- resolves the cassette (see {@see CassetteResolution}) and re-runs
 * it against the target app's real pipeline via {@see ReplayEngine}, returning the response diff
 * and drift report. Replays against the cassette's own recorded context when it has one, else
 * `contextName`. `ReplayEngine` itself enforces `replay.allow_live`/the non-idempotent-method
 * guard -- refusing either surfaces as the standard `{"error": "..."}` shape, same as any other
 * capability failure, not a special case here.
 */
final class ReplayCassette
{
    /** @return array<string, mixed> */
    public static function run(
        string $contextName,
        string $id,
        bool $force = false,
        ?string $key = null,
        ?string $date = null,
        ?string $hour = null,
    ): array {
        $resolved = CassetteResolution::resolve($contextName, $id, $key, $date, $hour);
        $cassette = $resolved['cassette'];

        $recordedContext = $cassette->meta['context'] ?? null;
        $replayContextName = is_string($recordedContext) && $recordedContext !== '' ? $recordedContext : $contextName;

        $context = Context::getInstance($replayContextName);
        $result = (new ReplayEngine())->replay($context, $cassette, $force);

        return [
            '_schema_version' => 1,
            'id' => $id,
            'source' => $resolved['source'],
            'replayed_status' => $result->response->getStatusCode(),
            'recorded_status' => $cassette->response['status'] ?? null,
            'clean' => $result->drift->isClean(),
            'diagnostics' => array_map(static fn(Diagnostic $d): array => $d->toArray(), $result->drift->diagnostics),
        ];
    }
}
