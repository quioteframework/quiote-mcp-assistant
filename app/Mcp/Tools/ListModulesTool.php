<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Tools;

use QuioteMcpAssistant\Mcp\Introspection\TargetAppIntrospector;

/** `list_modules` -- module names discovered under the target app's module directory. */
final class ListModulesTool
{
    public function __construct(private readonly TargetAppIntrospector $introspector) {}

    /** @return array<string, mixed> */
    public function list(): array
    {
        return $this->introspector->run('modules');
    }
}
