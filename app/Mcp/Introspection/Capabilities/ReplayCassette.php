<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Introspection\Capabilities;

use Quiote\Context;
use Quiote\Replay\Replay\ReplayEngine;
use Quiote\Replay\Replay\ReplayMode;
use Quiote\Support\Compiler\Diagnostic;

/**
 * `replay_cassette(id, ...)` -- resolves the cassette (see {@see CassetteResolution}) and re-runs
 * it against the target app's real pipeline via {@see ReplayEngine}, returning the response diff
 * and drift report. Replays against the cassette's own recorded context when it has one, else
 * `contextName`.
 *
 * Always {@see ReplayMode::Isolated}, the engine's default: every ledger-backed subsystem answers
 * from the cassette's own recorded effects and nothing is performed, so this needs no
 * `replay.allow_live` and re-runs a recorded POST as readily as a GET. The engine's `$force` is
 * deliberately not exposed: it only ever feeds the live path's safe-method guard. Whatever the
 * engine does refuse -- a cassette with no replayable request, a database that cannot be isolated
 * -- surfaces as the standard `{"error": "..."}` shape, same as any other capability failure, not
 * a special case here.
 */
final class ReplayCassette
{
    /** @return array<string, mixed> */
    public static function run(
        string $contextName,
        string $id,
        ?string $key = null,
        ?string $date = null,
        ?string $hour = null,
    ): array {
        $resolved = CassetteResolution::resolve($contextName, $id, $key, $date, $hour);
        $cassette = $resolved['cassette'];

        $recordedContext = $cassette->meta['context'] ?? null;
        $replayContextName = is_string($recordedContext) && $recordedContext !== '' ? $recordedContext : $contextName;

        $context = Context::getInstance($replayContextName);
        $result = (new ReplayEngine())->replay($context, $cassette);

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
