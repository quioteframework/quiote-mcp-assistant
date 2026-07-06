<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Introspection;

use QuioteMcpAssistant\Mcp\Support\Cfg;

/**
 * Runs `probe.php` as an isolated subprocess (via {@see IsolatedProcess})
 * against the configured target app and decodes its one JSON result (see
 * `probe.php`'s docblock for *why* a subprocess, not an in-process bootstrap
 * of a second app).
 */
final class TargetAppIntrospector
{
    /**
     * @param array<string, string> $args extra `--key=value` probe options
     * @return array<string, mixed>
     */
    public function run(string $capability, array $args = []): array
    {
        $appDir = trim(Cfg::string('assistant.target_app_dir'));
        if ($appDir === '') {
            return ['error' => 'No target app configured. Launch bin/quiote-assistant with --target-app-dir=/path/to/app to enable project-aware tools.'];
        }
        if (!is_dir($appDir)) {
            return ['error' => sprintf('Configured target app directory "%s" does not exist.', $appDir)];
        }

        $probeArgs = ['--app-dir=' . $appDir, '--capability=' . $capability];
        foreach ($args as $key => $value) {
            $probeArgs[] = '--' . $key . '=' . $value;
        }
        $command = IsolatedProcess::scriptCommand(__DIR__ . '/probe.php', $probeArgs);

        $result = IsolatedProcess::run($command);

        if ($result['timedOut']) {
            return ['error' => sprintf('Introspection probe for "%s" timed out.', $capability)];
        }

        $decoded = json_decode(trim($result['stdout']), true);
        if (!is_array($decoded) || ($decoded !== [] && array_is_list($decoded))) {
            return [
                'error' => 'Introspection probe produced no valid JSON output.',
                'stderr' => trim($result['stderr']),
            ];
        }

        // The probe's own {"error": "..."} failure shape passes through as-is.
        return $decoded;
    }
}
