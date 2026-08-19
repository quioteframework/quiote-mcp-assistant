<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Tools;

use QuioteMcpAssistant\Mcp\Introspection\Capabilities\ListFailedRequests;
use QuioteMcpAssistant\Mcp\Introspection\CassetteIntrospector;

/**
 * `list_failed_requests(since?, limit?)` -- candidate cassette ids for "what broke", newest first.
 *
 * Answered from a target app when one is configured, and otherwise from a cassette store this
 * assistant was pointed at directly -- reading a store needs no source tree. See
 * {@see CassetteIntrospector}.
 */
final class ListFailedRequestsTool
{
    public function __construct(private readonly CassetteIntrospector $introspector) {}

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

        return $this->introspector->run(
            'list_failed_requests',
            $args,
            static fn(string $contextName): array => ListFailedRequests::run($contextName, $since, $limit),
        );
    }
}
