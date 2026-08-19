<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Tools;

use QuioteMcpAssistant\Mcp\Introspection\TargetAppIntrospector;

/** `emit_replay_test(id, key?, date?, hour?, expect_fixed?)` -- writes a committed regression test from a cassette. */
final class EmitReplayTestTool
{
    public function __construct(private readonly TargetAppIntrospector $introspector) {}

    /** @return array<string, mixed> */
    public function emit(string $id, ?string $key = null, ?string $date = null, ?string $hour = null, bool $expectFixed = false): array
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
        if ($expectFixed) {
            $args['expect-fixed'] = '1';
        }

        return $this->introspector->run('emit_replay_test', $args);
    }
}
