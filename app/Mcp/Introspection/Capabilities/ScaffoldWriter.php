<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Introspection\Capabilities;

/**
 * Shared apply/preview logic for every `scaffold_*` capability: scaffolding
 * tools are explicit, support `dry_run`, and return diffs for approval.
 *
 * Two safety properties, both unconditional (not just when `dry_run`):
 * - **Never overwrites an existing file.** A path that already exists is
 *   always reported `skipped_exists`, in both dry-run and write mode --
 *   scaffolding only ever *creates*, never modifies.
 * - **`dry_run` defaults to true** in every caller -- nothing is written
 *   unless the caller explicitly passes `dry_run: false`.
 */
final class ScaffoldWriter
{
    /**
     * @param list<array{path: string, content: string}> $files
     * @return array{_schema_version: int, dry_run: bool, files: list<array{path: string, status: string, diff?: string}>}
     */
    public static function apply(string $appDir, array $files, bool $dryRun): array
    {
        $results = [];

        foreach ($files as $file) {
            $path = $file['path'];
            $relative = self::relativePath($appDir, $path);

            if (is_file($path)) {
                $results[] = ['path' => $relative, 'status' => 'skipped_exists'];
                continue;
            }

            if ($dryRun) {
                $results[] = [
                    'path' => $relative,
                    'status' => 'would_create',
                    'diff' => self::toDiff($relative, $file['content']),
                ];
                continue;
            }

            // Both calls' failures are already anticipated and turned into a
            // clean, structured status below -- @ here suppresses only the
            // redundant native PHP warning for a failure this code already
            // checks the return value of and handles explicitly.
            $dir = dirname($path);
            if (!is_dir($dir) && !@mkdir($dir, 0o775, true) && !is_dir($dir)) {
                $results[] = ['path' => $relative, 'status' => 'failed_mkdir'];
                continue;
            }

            if (@file_put_contents($path, $file['content']) === false) {
                $results[] = ['path' => $relative, 'status' => 'failed_write'];
                continue;
            }

            $results[] = ['path' => $relative, 'status' => 'created'];
        }

        return ['_schema_version' => 1, 'dry_run' => $dryRun, 'files' => $results];
    }

    private static function relativePath(string $appDir, string $path): string
    {
        $appDir = rtrim($appDir, '/');
        return str_starts_with($path, $appDir . '/') ? substr($path, strlen($appDir) + 1) : $path;
    }

    /** A unified-diff-style preview of a brand-new file (a pure addition against no prior content). */
    private static function toDiff(string $relativePath, string $content): string
    {
        $lines = explode("\n", $content);
        if (end($lines) === '') {
            array_pop($lines); // trailing newline in $content shouldn't become a phantom "+".
        }

        $diff = "--- /dev/null\n+++ b/{$relativePath}\n@@ -0,0 +1," . count($lines) . " @@\n";
        foreach ($lines as $line) {
            $diff .= '+' . $line . "\n";
        }

        return $diff;
    }
}
