<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Tools;

use QuioteMcpAssistant\Mcp\Introspection\TargetAppIntrospector;

/** `list_failed_requests(since?, limit?)` -- candidate cassette ids for "what broke", newest first. */
final class ListFailedRequestsTool
{
    public function __construct(private readonly TargetAppIntrospector $introspector) {}

    /** @return array<string, mixed> */
    public function list(?string $since = null, ?int $limit = null): array
    {
        $args = [];
        if ($since !== null) {
            $args['since'] = $since;
        }
        if ($limit !== null) {
            $args['limit'] = (string) $limit;
        }

        return $this->introspector->run('list_failed_requests', $args);
    }
}
