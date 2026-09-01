<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Tools;

use QuioteMcpAssistant\Mcp\Introspection\TargetAppIntrospector;

/** `replay_cassette(id, key?, date?, hour?)` -- re-runs a cassette in isolation and returns the response diff + drift report. */
final class ReplayCassetteTool
{
    public function __construct(private readonly TargetAppIntrospector $introspector) {}

    /** @return array<string, mixed> */
    public function replay(string $id, ?string $key = null, ?string $date = null, ?string $hour = null): array
    {
        $args = ['id' => $id];
        if ($key !== null) {
            $args['key'] = $key;
        }
        if ($date !== null) {
            $args['date'] = $date;
        }
        if ($hour !== null) {
            $args['hour'] = $hour;
        }

        return $this->introspector->run('replay_cassette', $args);
    }
}
