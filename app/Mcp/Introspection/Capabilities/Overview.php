<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Introspection\Capabilities;

use Quiote\Introspection\AppIntrospectionCompiler;

/**
 * `overview` -- routes + modules + triads + diagnostics + dependency
 * manifest + shadowed-config info, all from **one** app bootstrap. The
 * biggest responsiveness win over calling `routes`/`modules`/`project_info`
 * separately, each of which pays its own `Quiote::bootstrap()` when run as
 * an isolated probe subprocess.
 *
 * Reuses `Quiote\Introspection\AppIntrospectionCompiler` verbatim -- the
 * exact same compiler `routes:compile` writes `cache/introspection/app.json`
 * from -- rather than re-deriving any of routes/triads/diagnostics here, so
 * the probe's live (cache-miss) answer and the cached artifact never drift
 * out of shape from each other.
 */
final class Overview
{
    /**
     * @return array{
     *     _schema_version: int,
     *     source_hash: string,
     *     config_format: ?string,
     *     modules: list<array{name: string, dir: string, actions: list<string>}>,
     *     routes: list<array{name: string, path: string, methods: list<string>, module: string, action: string, outputType: ?string, source: string, file: ?string, line: ?int}>,
     *     triads: list<array{module: string, action: string, actionFile: string, viewFile: ?string, templateFile: ?string, verbs: list<array{name: string, line: ?int}>}>,
     *     diagnostics: list<array{severity: string, code: string, message: string, file: string, line: ?int, column: ?int, endLine: ?int, endColumn: ?int, symbol: ?string}>,
     *     dependencies: list<array{file: string, hash: string}>,
     *     shadowed: list<array{logical: string, loaded: ?string, ignored: list<string>}>,
     * }
     */
    public static function run(string $contextName): array
    {
        return (new AppIntrospectionCompiler())->compile($contextName);
    }
}
