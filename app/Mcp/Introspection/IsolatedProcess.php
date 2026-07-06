<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Introspection;

/**
 * Shared subprocess runner for every place this app shells out to isolate
 * itself from a target app's process-wide state (see `probe.php`'s docblock
 * for *why*) -- used by both {@see TargetAppIntrospector} (the `probe.php`
 * capabilities) and `RunConsoleTool` (the framework's own `quiote` console
 * commands). Kept in one place deliberately: this exact area (stdio
 * isolation, timeouts) has already produced real bugs this session, so one
 * reviewed implementation is safer than two similar-but-diverging ones.
 *
 * stdin is always a fresh, immediately-closed pipe -- never inherited from
 * this process's real stdin, which the live MCP stdio transport is
 * concurrently reading the client's JSON-RPC stream from.
 */
final class IsolatedProcess
{
    private const DEFAULT_TIMEOUT_SECONDS = 15.0;

    /**
     * Builds a `php <script> <args...>` command, phar-aware: PHP's CLI SAPI
     * cannot execute a bare `phar://` path as its main script argument
     * (confirmed: "Could not open input file: phar://...", even though
     * `require`ing that same path from an already-running script works
     * fine -- phar streams support reads, just not "be the entry point").
     * When $scriptPath lives inside the currently-running PHAR, this wraps
     * it via `-r`, which sidesteps that limitation, but needs two more
     * corrections to make the required script see a normally-shaped `$argv`
     * (`$argv[0]` a program-name placeholder, `$argv[1..]` the real args --
     * what a directly-invoked script would see):
     * - PHP's own `getopt()` returns nothing under `-r` despite `$argv`/
     *   `$_SERVER['argv']` being correctly populated (a confirmed quirk
     *   specific to `-r` execution) -- any script invoked this way
     *   (`probe.php`) must parse `$argv` by hand instead.
     * - The script path itself lands at `$argv[1]`, ahead of the real args,
     *   which a position-*sensitive* argv consumer (Symfony Console's
     *   `ArgvInput`, used by `vendor/bin/quiote`) would misread as the first
     *   real argument (confirmed: it mistook the script's own phar:// path
     *   for a command name). The inline snippet below splices that slot back
     *   out of both `$argv` and `$_SERVER['argv']` before requiring the
     *   target, so what it sees is indistinguishable from a direct
     *   invocation.
     *
     * @param list<string> $args
     * @return list<string>
     */
    public static function scriptCommand(string $scriptPath, array $args): array
    {
        if (\Phar::running(false) !== '' && str_starts_with($scriptPath, 'phar://')) {
            $bootstrap = '$s = $argv[1]; array_splice($argv, 1, 1); array_splice($_SERVER["argv"], 1, 1); '
                . '$_SERVER["argc"]--; require $s;';

            return array_merge(['php', '-r', $bootstrap, '--', $scriptPath], $args);
        }

        return array_merge(['php', $scriptPath], $args);
    }

    /**
     * @param list<string> $command
     * @return array{stdout: string, stderr: string, exitCode: int, timedOut: bool}
     */
    public static function run(array $command, float $timeoutSeconds = self::DEFAULT_TIMEOUT_SECONDS): array
    {
        $descriptors = [0 => ['pipe', 'r'], 1 => ['pipe', 'w'], 2 => ['pipe', 'w']];
        $process = proc_open($command, $descriptors, $pipes);
        if (!is_resource($process)) {
            return ['stdout' => '', 'stderr' => 'Could not launch process.', 'exitCode' => -1, 'timedOut' => false];
        }

        fclose($pipes[0]); // nothing to send -- the child sees immediate EOF on its stdin

        [$stdout, $stderr, $timedOut] = self::drain($pipes[1], $pipes[2], $timeoutSeconds);
        fclose($pipes[1]);
        fclose($pipes[2]);

        if ($timedOut) {
            proc_terminate($process);
            proc_close($process);

            return ['stdout' => $stdout, 'stderr' => $stderr, 'exitCode' => -1, 'timedOut' => true];
        }

        $exitCode = proc_close($process);

        return ['stdout' => $stdout, 'stderr' => $stderr, 'exitCode' => $exitCode, 'timedOut' => false];
    }

    /**
     * @param resource $stdout
     * @param resource $stderr
     * @return array{0: string, 1: string, 2: bool} [stdout, stderr, timedOut]
     */
    private static function drain($stdout, $stderr, float $timeoutSeconds): array
    {
        stream_set_blocking($stdout, false);
        stream_set_blocking($stderr, false);

        $out = '';
        $err = '';
        $deadline = microtime(true) + $timeoutSeconds;

        while (microtime(true) < $deadline) {
            $outChunk = fread($stdout, 8192);
            $errChunk = fread($stderr, 8192);
            if ($outChunk !== false) {
                $out .= $outChunk;
            }
            if ($errChunk !== false) {
                $err .= $errChunk;
            }

            if (feof($stdout) && feof($stderr)) {
                return [$out, $err, false];
            }

            usleep(10000);
        }

        return [$out, $err, true];
    }
}
