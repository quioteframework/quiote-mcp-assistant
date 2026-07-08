<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Introspection\Capabilities;

use Quiote\Config\Config;
use Quiote\Config\DatabaseConfigHandler;
use Quiote\Config\XmlConfigParser;

/**
 * `list_db_connections` -- parses the target app's `Config/databases.xml`
 * directly through the same `XmlConfigParser` + `databases.xsl` +
 * {@see DatabaseConfigHandler::toCanonicalArray()} pipeline the framework's
 * own `DatabaseManager` compiles at boot, but standalone (no `core.use_database`
 * requirement, no `DatabaseManager` instantiation) so this works even for an
 * app that hasn't enabled the database layer.
 *
 * Safety (read-only, never touches DB data): reports
 * each connection's adapter class and parameter *names* only, never the
 * parameter values -- `databases.xml` routinely holds DSNs/usernames/passwords
 * inline, and this tool must never be a way to exfiltrate them.
 */
final class ListDbConnections
{
    /** @return array<string, mixed> */
    public static function run(): array
    {
        $configDir = Config::getString('core.config_dir');
        $path = rtrim($configDir, '/') . '/databases.xml';
        if (!is_file($path)) {
            return ['_schema_version' => 1, 'found' => false, 'default' => null, 'databases' => []];
        }

        $document = XmlConfigParser::run(
            $path,
            Config::getString('core.environment'),
            '',
            [
                XmlConfigParser::STAGE_SINGLE => [Config::getString('core.quiote_dir') . '/Config/xsl/databases.xsl'],
                XmlConfigParser::STAGE_COMPILATION => [],
            ],
            [
                XmlConfigParser::STAGE_SINGLE => [
                    XmlConfigParser::STEP_TRANSFORMATIONS_BEFORE => [],
                    XmlConfigParser::STEP_TRANSFORMATIONS_AFTER => [],
                ],
                XmlConfigParser::STAGE_COMPILATION => [
                    XmlConfigParser::STEP_TRANSFORMATIONS_BEFORE => [],
                    XmlConfigParser::STEP_TRANSFORMATIONS_AFTER => [],
                ],
            ],
        );

        $canonical = (new DatabaseConfigHandler())->toCanonicalArray($document);

        $databases = [];
        foreach ($canonical['databases'] as $name => $db) {
            $databases[$name] = [
                'class' => $db['class'],
                'parameter_keys' => array_keys($db['parameters']),
            ];
        }

        return [
            '_schema_version' => 1,
            'found' => true,
            'default' => $canonical['default'] ?? null,
            'databases' => $databases,
        ];
    }
}
