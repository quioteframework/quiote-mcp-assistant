<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Tools;

use QuioteMcpAssistant\Mcp\Reflection\FrameworkApi;

/**
 * `list_api` -- browse the `Quiote\*` namespace tree. With no `namespace`,
 * returns the top-level namespaces (the
 * framework has 400+ classes -- dumping all of them unfiltered would be
 * useless) so the agent can drill down; with a `namespace`, lists every
 * class/interface/trait/enum under it (including sub-namespaces) with a
 * one-line summary, ready to hand to `describe_symbol` for full detail.
 */
final class ListApiTool
{
    private const DEFAULT_LIMIT = 50;
    private const MAX_LIMIT = 200;

    public function __construct(private readonly FrameworkApi $api) {}

    /** @return array<string, mixed> */
    public function list(?string $namespace = null, int $limit = self::DEFAULT_LIMIT): array
    {
        if ($namespace === null || trim($namespace) === '') {
            return [
                'namespace' => null,
                'namespaces' => $this->api->topLevelNamespaces(),
                'hint' => 'Call again with one of these as "namespace" to list its classes.',
            ];
        }

        $namespace = ltrim(trim($namespace), '\\');
        if (!$this->api->isFrameworkSymbol($namespace)) {
            return [
                'namespace' => $namespace,
                'error' => sprintf('"%s" is outside the Quiote\\ namespace this tool lists.', $namespace),
            ];
        }

        $limit = max(1, min(self::MAX_LIMIT, $limit));
        $fqcns = $this->api->classesUnder($namespace);

        $classes = [];
        foreach (array_slice($fqcns, 0, $limit) as $fqcn) {
            if (!$this->api->classLikeExists($fqcn)) {
                continue;
            }
            try {
                $classes[] = $this->api->summarize($fqcn);
            } catch (\Throwable) {
                // Same class of issue as FrameworkApi::classLikeExists() --
                // e.g. a parent/interface behind a dependency this app doesn't
                // have installed. Skip it rather than failing the whole listing.
                continue;
            }
        }

        return [
            'namespace' => $namespace,
            'total' => count($fqcns),
            'count' => count($classes),
            'truncated' => count($fqcns) > $limit,
            'classes' => $classes,
        ];
    }
}
