<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Introspection\Capabilities;

use InvalidArgumentException;
use Quiote\Replay\Cassette\CassetteProjector;

/**
 * `describe_cassette(id, ...)` -- the redacted analysis payload for one cassette: request/response
 * bodies excerpted to length + sha256 and effect rows excerpted to a count by default (pass
 * `include_bodies` for the full content), resolved via {@see CassetteResolution}. `section`
 * narrows to one top-level key -- this is also what backs the `cassette_section` tool under its
 * own name, since the two are the same operation with or without a filter.
 */
final class DescribeCassette
{
    /** @return array<string, mixed> */
    public static function run(
        string $contextName,
        string $id,
        bool $includeBodies = false,
        ?string $section = null,
        ?string $key = null,
        ?string $date = null,
        ?string $hour = null,
    ): array {
        $resolved = CassetteResolution::resolve($contextName, $id, $key, $date, $hour);
        $projection = CassetteProjector::project($resolved['cassette'], $includeBodies);

        if ($section !== null && $section !== '') {
            if (!array_key_exists($section, $projection)) {
                throw new InvalidArgumentException(sprintf('Unknown section "%s"; expected one of: %s.', $section, implode(', ', array_keys($projection))));
            }
            $projection = [$section => $projection[$section]];
        }

        return array_merge([
            '_schema_version' => 1,
            'id' => $id,
            'source' => $resolved['source'],
            'cached_path' => $resolved['cached_path'],
        ], $projection);
    }
}
