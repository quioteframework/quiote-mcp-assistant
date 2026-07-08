<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Introspection\Capabilities;

use Quiote\Introspection\AppIntrospectionCompiler;

/**
 * `diagnostics` -- flat, ready-to-map list aggregating every problem this
 * app can find in one call: route/triad diagnostics (missing action class,
 * missing view/template, duplicate route name/path -- from
 * `AppIntrospectionCompiler`, the same compiler `routes:compile` uses) plus
 * config diagnostics (syntax/semantic/schema errors and shadowed-config
 * warnings -- from {@see ValidateConfig}, validating every known config
 * type). Each entry shares one shape regardless of source, converging on
 * `Quiote\Support\Compiler\Diagnostic::toArray()`'s field set -- a config
 * diagnostic's `keyPath` (dot-joined, e.g. "databases.default_db.class")
 * is carried through as `symbol`.
 */
final class Diagnostics
{
    /**
     * @return array{
     *     _schema_version: int,
     *     diagnostics: list<array{severity: string, code: string, message: string, file: ?string, line: ?int, column: ?int, endLine: ?int, endColumn: ?int, symbol: ?string}>,
     * }
     */
    public static function run(string $contextName): array
    {
        $artifact = (new AppIntrospectionCompiler())->compile($contextName);

        $diagnostics = $artifact['diagnostics'];
        foreach (ValidateConfig::run('')['diagnostics'] as $config) {
            $diagnostics[] = [
                'severity' => $config['severity'],
                'code' => $config['code'],
                'message' => $config['message'],
                'file' => $config['file'],
                'line' => $config['line'],
                'column' => $config['column'],
                'endLine' => $config['endLine'],
                'endColumn' => null,
                'symbol' => $config['keyPath'],
            ];
        }

        return ['_schema_version' => 1, 'diagnostics' => $diagnostics];
    }
}
