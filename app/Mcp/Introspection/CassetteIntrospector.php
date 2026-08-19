<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Introspection;

use Quiote\Config\Config;
use Quiote\Context;
use Quiote\Replay\Store\CassetteStoreInterface;
use Throwable;

/**
 * Routes a cassette capability to whichever cassette store is actually available.
 *
 * The other project-aware tools genuinely need a target app: a route list, a module list or a
 * scaffold only mean something relative to somebody's source tree. A cassette tool does not -- it
 * needs a *cassette store*, and a target-app checkout is only one way to have one. Requiring
 * `--target-app-dir` for all of them meant the "read cassette SUX2020 and tell me what broke"
 * workflow needed a local clone of the recording application even when the cassettes themselves
 * live in a blob container the agent's own credentials can already read.
 *
 * So there are two routes, in this order:
 *
 *  1. **A target app**, when `assistant.target_app_dir` is set: delegate to
 *     {@see TargetAppIntrospector}, which runs `probe.php` as a subprocess against that app. Its
 *     config, its plugins and its store -- which is what you want when the point is to reason about
 *     that application, and the only route that can replay a cassette or emit a test into it.
 *  2. **This assistant's own store**, when one is configured (`--cassette-store` at launch): call
 *     the capability in-process against this app's context. Read-only by nature: describing a
 *     cassette needs a store and nothing else.
 *
 * A target app wins when both are available, because a capability that can only be answered by one
 * of them (replaying, emitting a test) needs that one, and answering *some* tools from one store and
 * some from another would be worse than confusing.
 */
final class CassetteIntrospector
{
    public function __construct(private readonly TargetAppIntrospector $targetApp) {}

    /**
     * @param array<string, string> $args probe-style `--key=value` options
     * @param callable(string): array<string, mixed> $inProcess receives this app's context name
     * @return array<string, mixed>
     */
    public function run(string $capability, array $args, callable $inProcess): array
    {
        if (self::hasTargetApp()) {
            return $this->targetApp->run($capability, $args);
        }

        if (!self::hasOwnStore()) {
            return ['error' => self::noStoreMessage()];
        }

        try {
            return $inProcess(Config::getString('core.default_context', 'web'));
        } catch (Throwable $e) {
            // Mirrors probe.php's own failure shape, so a tool's caller sees one contract whichever
            // route answered it.
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Whether a capability that can only run against a target app is available -- replaying a
     * request or writing a test file both need the application, not just its cassettes.
     */
    public static function hasTargetApp(): bool
    {
        return trim(Config::getNullableString('assistant.target_app_dir') ?? '') !== '';
    }

    /** The message a cassette tool reports when neither route is available. */
    public static function noStoreMessage(): string
    {
        return 'No cassette source configured. Either launch bin/quiote-assistant with '
            . '--target-app-dir=/path/to/app to read the cassettes of a specific application, or with '
            . '--cassette-store=azure-blob --azure-account=NAME --azure-container=NAME to read a blob '
            . 'container directly (--azure-auth defaults to "cli", reusing your "az login" identity).';
    }

    /**
     * Whether this app was deliberately pointed at a cassette store of its own.
     *
     * The marker is checked *before* the store resolves, and that ordering is the point. A store
     * always resolves: `ReplayPlugin` registers a `FileCassetteStore` for the `file` default, so a
     * plain knowledge-only server would pass a "can I resolve a store" test and then answer every
     * cassette question from its own empty `var/cassettes` -- reporting "no cassettes found" for a
     * production id, which reads as an answer rather than as missing configuration. Only an explicit
     * `--cassette-store`/`--cassette-path` at launch sets the marker.
     *
     * Resolving it is still checked, because the marker says what was asked for and the store's own
     * constructor is where a bad path or a missing credential actually surfaces. Resolved through the
     * container, so the singleton is built once and reused by the capability that follows.
     */
    private static function hasOwnStore(): bool
    {
        if (Config::getNullableString('assistant.direct_cassette_store') === null) {
            return false;
        }

        try {
            // Resolved, not merely looked up: the store's own constructor is where a bad path or a
            // missing credential surfaces, and a marker without a usable store is still no route.
            Context::getInstance(Config::getString('core.default_context', 'web'))
                ->getContainer()
                ->get(CassetteStoreInterface::class);

            return true;
        } catch (Throwable) {
            return false;
        }
    }
}
