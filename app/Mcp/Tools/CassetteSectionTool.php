<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Tools;

use QuioteMcpAssistant\Mcp\Introspection\TargetAppIntrospector;

/**
 * `cassette_section(id, section, key?, date?, hour?, include_bodies?)` -- one top-level section of
 * a cassette (`meta`, `request`, `resolved`, `session`, `user`, `effects`, `response`,
 * `exception`, `log`) on demand, without paying for the whole projection. The same underlying
 * `describe_cassette` probe capability as {@see DescribeCassetteTool}, narrowed server-side.
 */
final class CassetteSectionTool
{
    public function __construct(private readonly TargetAppIntrospector $introspector) {}

    /** @return array<string, mixed> */
    public function section(string $id, string $section, ?string $key = null, ?string $date = null, ?string $hour = null, bool $includeBodies = false): array
    {
        return $this->introspector->run('describe_cassette', DescribeCassetteTool::args($id, $key, $date, $hour, $includeBodies, $section));
    }
}
