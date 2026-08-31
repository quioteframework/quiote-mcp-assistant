<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Introspection\Capabilities;

use Quiote\Config\Config;
use Quiote\Config\DatabaseConfigHandler;
use Quiote\Config\Format\FormatDriverRegistry;

/**
 * `list_db_connections` -- resolves the target app's `databases` config
 * through the framework's own {@see FormatDriverRegistry}, so a connection
 * declared in `databases.php` or `databases.yaml` is reported exactly like one
 * declared in `databases.xml`, with the same `.php` > `.yaml` > `.xml`
 * precedence the framework applies. The registry hands every format to
 * {@see DatabaseConfigHandler::toCanonicalArray()} (XML additionally passing
 * through `databases.xsl`), which is what `DatabaseManager` compiles at boot --
 * but standalone here (no `core.use_database` requirement, no `DatabaseManager`
 * instantiation), so this works even for an app that hasn't enabled the
 * database layer.
 *
 * Safety (read-only, never touches DB data): reports
 * each connection's adapter class and parameter *names* only, never the
 * parameter values -- a databases config routinely holds DSNs/usernames/passwords
 * inline, and this tool must never be a way to exfiltrate them.
 */
final class ListDbConnections
{
    /**
     * @param string|null $configDir The directory holding the `databases`
     *        config; defaults to the bootstrapped app's `core.config_dir`.
     * @return array<string, mixed>
     */
    public static function run(?string $configDir = null): array
    {
        $registry = FormatDriverRegistry::forHandler(
            new DatabaseConfigHandler(),
            [Config::getString('core.quiote_dir') . '/Config/xsl/databases.xsl'],
        );

        $path = $registry->locate(rtrim($configDir ?? Config::getString('core.config_dir'), '/') . '/databases');
        if ($path === null) {
            return ['_schema_version' => 1, 'found' => false, 'format' => null, 'default' => null, 'databases' => []];
        }

        $canonical = $registry->load($path, Config::getNullableString('core.environment'), '');

        $default = $canonical['default'] ?? null;
        $declared = $canonical['databases'] ?? [];

        $databases = [];
        if (is_array($declared)) {
            foreach ($declared as $name => $db) {
                if (!is_array($db)) {
                    continue;
                }
                $class = $db['class'] ?? null;
                $parameters = $db['parameters'] ?? [];
                $databases[(string) $name] = [
                    'class' => is_string($class) ? $class : null,
                    'parameter_keys' => is_array($parameters) ? array_keys($parameters) : [],
                ];
            }
        }

        return [
            '_schema_version' => 1,
            'found' => true,
            // Which format actually won resolution -- an app with both a
            // databases.php and a databases.xml on disk only uses the former.
            'format' => strtolower(pathinfo($path, PATHINFO_EXTENSION)),
            'default' => is_string($default) ? $default : null,
            'databases' => $databases,
        ];
    }
}
