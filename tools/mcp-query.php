<?php

declare(strict_types=1);

/**
 * Ad-hoc real-stdio-client query runner for manual search_docs ranking checks
 * (same robust proc_open + polling-read pattern as mcp-smoke-client.php,
 * which is needed because a naive one-shot `printf | php` pipe races the
 * server's non-blocking stdin loop and unreliably truncates the conversation
 * regardless of query content).
 *
 * Usage: php tools/mcp-query.php "some search query" [limit]
 */

$query = $argv[1] ?? 'routing';
$limit = isset($argv[2]) ? (int) $argv[2] : 5;

$repo = dirname(__DIR__);
$proc = proc_open(['php', $repo . '/bin/quiote-assistant'], [
    0 => ['pipe', 'r'],
    1 => ['pipe', 'w'],
    2 => ['pipe', 'w'],
], $pipes, $repo);

[$stdin, $stdout, $stderr] = $pipes;

$requests = [
    ['jsonrpc' => '2.0', 'id' => 1, 'method' => 'initialize', 'params' => [
        'protocolVersion' => '2025-11-25', 'capabilities' => [], 'clientInfo' => ['name' => 'x', 'version' => '1'],
    ]],
    ['jsonrpc' => '2.0', 'method' => 'notifications/initialized'],
    ['jsonrpc' => '2.0', 'id' => 2, 'method' => 'tools/call', 'params' => [
        'name' => 'search_docs', 'arguments' => ['query' => $query, 'limit' => $limit],
    ]],
];
foreach ($requests as $req) {
    fwrite($stdin, json_encode($req, JSON_THROW_ON_ERROR) . "\n");
}
fclose($stdin);

stream_set_blocking($stdout, false);
$buffer = '';
$responses = [];
$deadline = microtime(true) + 10.0;
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
proc_close($proc);

foreach ($responses as $r) {
    if (($r['id'] ?? null) === 2) {
        $data = json_decode($r['result']['content'][0]['text'], true);
        foreach ($data['results'] as $hit) {
            printf("%8.2f  %s\n", $hit['score'], $hit['uri']);
        }
    }
}
