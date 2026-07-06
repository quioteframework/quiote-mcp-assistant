<?php

declare(strict_types=1);

/**
 * Verifies the Streamable HTTP transport -- auth (missing/wrong/correct
 * bearer token) and a full `initialize` →
 * `notifications/initialized` → `tools/list` → `tools/call` →
 * `resources/read` conversation, driven as real PSR-7 requests through
 * `Quiote\Context::handle()` (the same full-pipeline entry point
 * `app/pub/index.php` uses for a real request).
 *
 * Deliberately **in-process**, not a real subprocess/HTTP server (contrast
 * `mcp-smoke-client.php`, which does spawn `bin/quiote-assistant`): the
 * stateful `2025-11-25` MCP session store lives in PHP process memory, and
 * PHP's built-in dev server (`php -S`) resets all process state between
 * requests (it re-executes the whole front controller from scratch every
 * time) -- confirmed empirically that this makes session continuity
 * impossible to test that way, not a bug in this app. A real HTTP
 * deployment needs a persistent-process runtime (FrankenPHP worker mode) or
 * a PDO-backed session store for sessions to survive across requests;
 * driving requests in-process here is the correct way to verify the
 * transport/auth/dispatch logic itself without standing one up.
 *
 * Usage: QUIOTE_ASSISTANT_MCP_TOKEN=... php tools/mcp-http-smoke-client.php
 * (falls back to a fixed test token if unset)
 */

$repo = dirname(__DIR__);
$appDir = $repo . '/app';
$token = getenv('QUIOTE_ASSISTANT_MCP_TOKEN') ?: 'smoke-test-token';
putenv('QUIOTE_ASSISTANT_MCP_TOKEN=' . $token);

spl_autoload_register(static function (string $class) use ($appDir): void {
    $prefix = 'QuioteMcpAssistant\\';
    if (!str_starts_with($class, $prefix)) {
        return;
    }
    $file = $appDir . '/' . str_replace('\\', '/', substr($class, strlen($prefix))) . '.php';
    if (is_file($file)) {
        require $file;
    }
});
require $repo . '/vendor/autoload.php';

// A stale compiled config cache would otherwise bake in whatever
// mcp.auth_token was set (or unset) the last time it was warmed.
foreach (glob($appDir . '/cache/config/*.php') ?: [] as $cached) {
    unlink($cached);
}

\Quiote\Config\Config::set('core.app_dir', $appDir, true, true);
\Quiote\Quiote::bootstrap('development');

$factory = new \Nyholm\Psr7\Factory\Psr17Factory();

function mcpRequest(\Nyholm\Psr7\Factory\Psr17Factory $factory, array $body, ?string $sessionId, ?string $token): \Psr\Http\Message\ServerRequestInterface
{
    $request = $factory->createServerRequest('POST', 'http://localhost/mcp')
        ->withHeader('Content-Type', 'application/json')
        ->withBody($factory->createStream(json_encode($body, JSON_THROW_ON_ERROR)));
    if ($token !== null) {
        $request = $request->withHeader('Authorization', 'Bearer ' . $token);
    }
    if ($sessionId !== null) {
        $request = $request->withHeader('Mcp-Session-Id', $sessionId);
    }

    return $request;
}

function dispatch(\Psr\Http\Message\ServerRequestInterface $request): \Psr\Http\Message\ResponseInterface
{
    return \Quiote\Context::getInstance('web')->handle($request);
}

$fail = 0;
$check = function (string $label, bool $ok, string $detail = '') use (&$fail): void {
    printf("[%s] %s%s\n", $ok ? 'PASS' : 'FAIL', $label, $detail !== '' ? " — {$detail}" : '');
    if (!$ok) {
        ++$fail;
    }
};

$initBody = ['jsonrpc' => '2.0', 'id' => 1, 'method' => 'initialize', 'params' => [
    'protocolVersion' => '2025-11-25', 'capabilities' => [], 'clientInfo' => ['name' => 'http-smoke', 'version' => '1.0'],
]];

$noAuthResp = dispatch(mcpRequest($factory, $initBody, null, null));
$check('missing bearer token is refused with 401', $noAuthResp->getStatusCode() === 401,
    'status=' . $noAuthResp->getStatusCode());

$wrongAuthResp = dispatch(mcpRequest($factory, $initBody, null, 'wrong-token'));
$check('wrong bearer token is refused with 401', $wrongAuthResp->getStatusCode() === 401,
    'status=' . $wrongAuthResp->getStatusCode());

$initResp = dispatch(mcpRequest($factory, $initBody, null, $token));
$initData = json_decode((string) $initResp->getBody(), true);
$sessionId = $initResp->getHeaderLine('Mcp-Session-Id');
$check('correct bearer token: initialize succeeds and returns a session id',
    $initResp->getStatusCode() === 200
        && ($initData['result']['serverInfo']['name'] ?? '') === 'quiote-assistant'
        && $sessionId !== '',
    'status=' . $initResp->getStatusCode() . ', session=' . $sessionId);

dispatch(mcpRequest($factory, ['jsonrpc' => '2.0', 'method' => 'notifications/initialized'], $sessionId, $token));

$listResp = dispatch(mcpRequest($factory, ['jsonrpc' => '2.0', 'id' => 2, 'method' => 'tools/list'], $sessionId, $token));
$listData = json_decode((string) $listResp->getBody(), true);
$toolNames = array_map(static fn ($t) => $t['name'], $listData['result']['tools'] ?? []);
$check('tools/list works within the session', in_array('search_docs', $toolNames, true),
    'tools=' . implode(',', $toolNames));

$callResp = dispatch(mcpRequest($factory, [
    'jsonrpc' => '2.0', 'id' => 3, 'method' => 'tools/call',
    'params' => ['name' => 'search_docs', 'arguments' => ['query' => 'define a route', 'limit' => 2]],
], $sessionId, $token));
$callData = json_decode((string) $callResp->getBody(), true);
$searchResult = json_decode($callData['result']['content'][0]['text'] ?? 'null', true);
$check('tools/call search_docs works within the session',
    ($searchResult['results'][0]['uri'] ?? '') === 'quiote-docs://basics/routing',
    'top=' . ($searchResult['results'][0]['uri'] ?? '?'));

$readResp = dispatch(mcpRequest($factory, [
    'jsonrpc' => '2.0', 'id' => 4, 'method' => 'resources/read',
    'params' => ['uri' => 'quiote-docs://basics/routing'],
], $sessionId, $token));
$readData = json_decode((string) $readResp->getBody(), true);
$check('resources/read works within the session',
    str_contains($readData['result']['contents'][0]['text'] ?? '', '# Routing'),
    'status=' . $readResp->getStatusCode());

echo "\n";
if ($fail === 0) {
    echo "ALL CHECKS PASSED\n";
} else {
    echo "{$fail} CHECK(S) FAILED\n";
}

exit($fail === 0 ? 0 : 1);
