<?php

declare(strict_types=1);

/**
 * Regression test for three real bugs found (and since fixed upstream) in
 * `quioteframework/mcp`'s "expose an existing #[Route] action as an MCP
 * tool" feature -- the exact mechanism the `expose-action-as-tool` recipe
 * and `#[McpTool]` convention teach:
 *
 *  1. `McpServer::buildToolInputSchema()` used to emit `'required' => null`
 *     for any action whose schema couldn't be derived from an XML validator
 *     file -- which the SDK's own opis/json-schema request-argument
 *     validator rejects outright ("required must be an array of strings"),
 *     making the tool completely uncallable regardless of what arguments
 *     were sent. Fixed: `normalizeRequiredList()` now always returns an
 *     array.
 *  2. `ActionToolScanner::deriveInputSchema()` used to only understand the
 *     `{module}/Validate/{action}.xml` file convention, silently deriving
 *     no schema at all for the fluent `register{Method}Validators()` style
 *     every documented example (and this app's own recipes) actually use.
 *     Fixed: it now also runs that hook against a throwaway
 *     ValidationManager and reads back the schema.
 *  3. `ActionToolScanner::scan()` used to bind a tool to `$route->methods[0]`
 *     unconditionally -- whichever HTTP method happens to be listed first
 *     in the action's own `#[Route(methods: [...])]`, not necessarily the
 *     verb that does the actual work. A `['GET', 'POST']` route (GET for an
 *     empty form, POST for the real write) would silently dispatch every
 *     tool call to the no-op read verb. Fixed: `resolvePrimaryHttpMethod()`
 *     now prefers the first verb HttpMethodMapper doesn't map to 'read'.
 *
 * This drives a real `vendor/bin/quiote mcp:serve` subprocess (the target
 * app's OWN command, run via this repo's autoloader -- see below) against a
 * hand-written action, not this assistant's own tool layer, since these
 * bugs only manifest through the SDK's real schema-validation + dispatch
 * pipeline, not at the capability/introspection level this app's other
 * tests already cover.
 *
 * Why `vendor/bin/quiote` from THIS repo works against an *external* scratch
 * app dir: `quiote new` deliberately gives the generated app no composer.json
 * of its own (its front controller looks upward for a `vendor/autoload.php`
 * that has Quiote in it) -- so running the command via this repo's own
 * install (which already requires both quioteframework/quiote and
 * quioteframework/mcp) and pointing `--app-dir` at the scratch app boots
 * that app's own Config/plugins/routes for real, with no extra `composer
 * require` needed inside the scratch dir itself.
 *
 * Usage: php tools/mcp-smoke-client-expose-tool.php /path/to/scratch/app
 */

$scratchAppDir = $argv[1] ?? null;
if ($scratchAppDir === null || !is_dir($scratchAppDir)) {
    fwrite(STDERR, "Usage: php tools/mcp-smoke-client-expose-tool.php /path/to/scratch/app\n");
    exit(1);
}
$scratchAppDir = realpath($scratchAppDir);

$repo = dirname(__DIR__);
$quioteBin = $repo . '/vendor/bin/quiote';

// --- Fixture setup: an action exposed as an MCP tool via a multi-verb
// route (GET listed before POST, deliberately -- see bug #3 above) with a
// fluent-builder-only schema (no Validate/*.xml file anywhere), matching
// exactly the shape that used to be completely broken.

$settingsFile = $scratchAppDir . '/Config/settings.php';
$settings = require $settingsFile;
if (!is_array($settings)) {
    fwrite(STDERR, "Could not read {$settingsFile} as a PHP array.\n");
    exit(1);
}
$settings['plugins'] = [\Quiote\Mcp\McpPlugin::class];
$settings['mcp.enabled'] = true;
$settings['mcp.expose_actions'] = true;
$settings['mcp.server_name'] = 'expose-tool-smoke';
$settings['mcp.server_version'] = '0.0.0';
file_put_contents($settingsFile, "<?php\n\nreturn " . var_export($settings, true) . ";\n");

$actionsDir = $scratchAppDir . '/Modules/Blog/Actions';
$viewsDir = $scratchAppDir . '/Modules/Blog/Views';
$templatesDir = $scratchAppDir . '/Modules/Blog/Templates';
foreach ([$actionsDir, $viewsDir, $templatesDir] as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0o775, true);
    }
}

$markerFile = sys_get_temp_dir() . '/mcp-expose-tool-smoke-' . bin2hex(random_bytes(8)) . '.marker';
@unlink($markerFile);

file_put_contents($actionsDir . '/CreatePostAction.php', <<<PHP
    <?php
    namespace App\Modules\Blog\Actions;

    use Mcp\Capability\Attribute\McpTool;
    use Quiote\Action\Action;
    use Quiote\Request\WebRequest;
    use Quiote\Routing\Attribute\Route;
    use Quiote\Validator\Compiler\Runtime\ValidatorBuilder;

    #[Route(path: '/blog/create', name: 'blog.create', methods: ['GET', 'POST'])]
    #[McpTool(name: 'create_blog_post')]
    class CreatePostAction extends Action
    {
        public function executeRead(WebRequest \$rd)
        {
            return 'Input';
        }

        public function executeWrite(WebRequest \$rd)
        {
            file_put_contents('{$markerFile}', (string) \$rd->getParameter('title'));
            return 'Success';
        }

        public function registerWriteValidators(): void
        {
            \$v = ValidatorBuilder::on(
                \$this->getInitContext()->getValidationManager(),
                \$this->getContext(),
            );
            \$v->string('title', required: true)->minLength(1);
        }

        public function getDefaultViewName(): string
        {
            return 'Input';
        }
    }

    PHP);

foreach (['Input', 'Success'] as $viewName) {
    file_put_contents("{$viewsDir}/CreatePost{$viewName}View.php", <<<PHP
        <?php
        namespace App\Modules\Blog\Views;

        use Quiote\Exception\ViewException;
        use Quiote\Request\WebRequest;
        use Quiote\View\View;

        class CreatePost{$viewName}View extends View
        {
            public function execute(WebRequest \$rd): never
            {
                throw new ViewException('no such output type');
            }

            public function executeHtml(WebRequest \$rd): void
            {
                \$this->loadLayout();
            }
        }

        PHP);
    file_put_contents("{$templatesDir}/CreatePost{$viewName}.php", "<?= '{$viewName}' ?>\n");
}

// A stale compiled settings/routing cache from a previous run of this
// script (or an earlier scratch-app use) must not mask the fixture above.
$configCacheDir = $scratchAppDir . '/cache/config';
if (is_dir($configCacheDir)) {
    foreach (glob($configCacheDir . '/*') ?: [] as $cached) {
        @unlink($cached);
    }
}

// --- Drive a real `mcp:serve` subprocess over stdio.

$proc = proc_open(
    [$quioteBin, 'mcp:serve', '--app-dir=' . $scratchAppDir],
    [0 => ['pipe', 'r'], 1 => ['pipe', 'w'], 2 => ['pipe', 'w']],
    $pipes,
    $repo,
);
if (!\is_resource($proc)) {
    fwrite(STDERR, "Failed to launch mcp:serve.\n");
    exit(1);
}
[$stdin, $stdout, $stderr] = $pipes;

$requests = [
    ['jsonrpc' => '2.0', 'id' => 1, 'method' => 'initialize', 'params' => [
        'protocolVersion' => '2025-11-25', 'capabilities' => [], 'clientInfo' => ['name' => 'expose-tool-smoke-client', 'version' => '1.0'],
    ]],
    ['jsonrpc' => '2.0', 'method' => 'notifications/initialized'],
    ['jsonrpc' => '2.0', 'id' => 2, 'method' => 'tools/list'],
    // Missing the required "title" must be rejected at the schema level,
    // before the action ever runs -- proves validation is real, not just
    // "doesn't crash" (bug #1's fix could otherwise hide a schema that's
    // technically valid JSON Schema but accepts anything).
    ['jsonrpc' => '2.0', 'id' => 3, 'method' => 'tools/call', 'params' => [
        'name' => 'create_blog_post', 'arguments' => [],
    ]],
    ['jsonrpc' => '2.0', 'id' => 4, 'method' => 'tools/call', 'params' => [
        'name' => 'create_blog_post', 'arguments' => ['title' => 'Hello World'],
    ]],
];

foreach ($requests as $req) {
    fwrite($stdin, json_encode($req, JSON_THROW_ON_ERROR) . "\n");
}
fclose($stdin);

stream_set_blocking($stdout, false);
stream_set_blocking($stderr, false);
$responses = [];
$buffer = '';
$deadline = microtime(true) + 20.0;
while (microtime(true) < $deadline) {
    $chunk = fread($stdout, 8192);
    if ($chunk !== false && $chunk !== '') {
        $buffer .= $chunk;
        while (($nl = strpos($buffer, "\n")) !== false) {
            $line = trim(substr($buffer, 0, $nl));
            $buffer = substr($buffer, $nl + 1);
            if ($line !== '') {
                $responses[] = json_decode($line, true);
            }
        }
    } elseif (feof($stdout)) {
        break;
    } else {
        usleep(20000);
    }
}
$errOut = stream_get_contents($stderr);
fclose($stdout);
fclose($stderr);
proc_close($proc);

$byId = [];
foreach ($responses as $r) {
    if (isset($r['id'])) {
        $byId[$r['id']] = $r;
    }
}

$fail = 0;
$check = function (string $label, bool $ok, string $detail = '') use (&$fail): void {
    printf("[%s] %s%s\n", $ok ? 'PASS' : 'FAIL', $label, $detail !== '' ? " — {$detail}" : '');
    if (!$ok) {
        ++$fail;
    }
};

$toolsListResult = $byId[2]['result'] ?? null;
$tool = null;
foreach ($toolsListResult['tools'] ?? [] as $candidate) {
    if (($candidate['name'] ?? null) === 'create_blog_post') {
        $tool = $candidate;
        break;
    }
}
$required = $tool['inputSchema']['required'] ?? 'MISSING';
$check(
    'tools/list advertises create_blog_post with a real, non-null "required" array (bug #1 + #2)',
    $tool !== null && is_array($required) && in_array('title', $required, true)
        && isset($tool['inputSchema']['properties']['title']),
    'required=' . json_encode($required),
);

$missingTitleError = $byId[3]['error'] ?? null;
$check(
    'tools/call without the required "title" is rejected before the action runs',
    $missingTitleError !== null && str_contains($missingTitleError['message'] ?? '', 'title'),
    'response=' . json_encode($missingTitleError),
);

$createResult = $byId[4]['result'] ?? null;
$check(
    'tools/call with a valid "title" succeeds (no schema-validation error)',
    $createResult !== null && ($createResult['isError'] ?? true) === false,
    'response=' . json_encode($createResult ?? ($byId[4]['error'] ?? null)),
);

$markerContents = is_file($markerFile) ? file_get_contents($markerFile) : null;
$check(
    'the call actually dispatched to executeWrite(), not the GET-first executeRead() (bug #3)',
    $markerContents === 'Hello World',
    'marker=' . var_export($markerContents, true),
);

@unlink($markerFile);

echo "\n";
if ($fail === 0) {
    echo "ALL CHECKS PASSED (" . count($byId) . " responses)\n";
} else {
    echo "{$fail} CHECK(S) FAILED\n\n--- stderr ---\n{$errOut}\n--- raw responses ---\n";
    foreach ($responses as $r) {
        echo substr(json_encode($r), 0, 500) . "\n";
    }
}

exit($fail === 0 ? 0 : 1);
