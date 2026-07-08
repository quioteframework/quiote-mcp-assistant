<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Tools;

use QuioteMcpAssistant\Mcp\Introspection\TargetAppIntrospector;

/**
 * `diagnostics` -- every problem this app can find in one call: routing
 * (missing action class, duplicate route), triad (missing view/template),
 * and config (syntax/semantic/schema errors, shadowed configs), as one flat
 * list sharing a single {severity, code, message, file, line, ...} shape.
 */
final class DiagnosticsTool
{
    public function __construct(private readonly TargetAppIntrospector $introspector) {}

    /** @return array<string, mixed> */
    public function diagnostics(): array
    {
        return $this->introspector->run('diagnostics');
    }
}
