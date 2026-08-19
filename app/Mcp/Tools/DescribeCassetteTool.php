<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Tools;

use QuioteMcpAssistant\Mcp\Introspection\Capabilities\DescribeCassette;
use QuioteMcpAssistant\Mcp\Introspection\CassetteIntrospector;

/**
 * `describe_cassette(id, key?, date?, hour?, include_bodies?)` -- the redacted analysis payload
 * for one cassette. `key`/`date`/`hour` are resolution hints for an id not already local or in the
 * configured store, per `Quiote\Replay\Index\CassetteIndexInterface`'s own chain.
 *
 * Answered from a target app when one is configured, and otherwise from a cassette store this
 * assistant was pointed at directly -- reading a cassette needs no source tree. See
 * {@see CassetteIntrospector}.
 */
final class DescribeCassetteTool
{
    public function __construct(private readonly CassetteIntrospector $introspector) {}

    /** @return array<string, mixed> */
    public function describe(string $id, ?string $key = null, ?string $date = null, ?string $hour = null, bool $includeBodies = false): array
    {
        return $this->introspector->run(
            'describe_cassette',
            self::args($id, $key, $date, $hour, $includeBodies),
            static fn(string $contextName): array => DescribeCassette::run($contextName, $id, $includeBodies, null, $key, $date, $hour),
        );
    }

    /** @return array<string, string> */
    public static function args(string $id, ?string $key, ?string $date, ?string $hour, bool $includeBodies, ?string $section = null): array
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
        if ($includeBodies) {
            $args['include-bodies'] = '1';
        }
        if ($section !== null) {
            $args['section'] = $section;
        }

        return $args;
    }
}
