<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Introspection\Capabilities;

use Quiote\Replay\Cassette\CassetteId;
use Quiote\Replay\Testing\ReplayTestEmission;

/**
 * `emit_replay_test(id, ...)` -- resolves the cassette (see {@see CassetteResolution}) and writes
 * a committed regression test from it via {@see ReplayTestEmission}, the same operation
 * `quiote replay <id> --as-test` performs. Does not replay first (unlike the console command,
 * which always diffs before emitting) -- an agent that already ran `replay_cassette` and confirmed
 * the repro locally shouldn't have to pay for a second dispatch just to emit the test from the
 * cassette it already has.
 */
final class EmitReplayTest
{
    /** @return array<string, mixed> */
    public static function run(
        string $contextName,
        string $id,
        bool $expectFixed = false,
        ?string $key = null,
        ?string $date = null,
        ?string $hour = null,
    ): array {
        $resolved = CassetteResolution::resolve($contextName, $id, $key, $date, $hour);
        $emitted = ReplayTestEmission::emit(CassetteId::fromRaw($id), $resolved['cassette'], $expectFixed);

        return [
            '_schema_version' => 1,
            'id' => $id,
            'source' => $resolved['source'],
            'test' => $emitted['test'],
            'cassette' => $emitted['cassette'],
        ];
    }
}
