<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Tools;

use QuioteMcpAssistant\Mcp\Introspection\TargetAppIntrospector;

/**
 * `overview` -- routes + modules + triads + diagnostics + shadowed-config
 * info, all from one app bootstrap. Prefer this over calling
 * `list_routes`/`list_modules`/`describe_action` separately when you need
 * more than one of them, since each of those pays its own bootstrap as an
 * isolated probe subprocess.
 */
final class OverviewTool
{
    public function __construct(private readonly TargetAppIntrospector $introspector) {}

    /** @return array<string, mixed> */
    public function overview(): array
    {
        return $this->introspector->run('overview');
    }
}
