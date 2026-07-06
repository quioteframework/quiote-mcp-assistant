<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Introspection\Capabilities;

use Quiote\Config\Config;

/**
 * `scaffold_db_connection(name, driver)` -- two outcomes, depending on
 * whether `Config/databases.xml` already exists (this tool never modifies
 * an existing file, see {@see ScaffoldWriter}):
 * - **Doesn't exist**: creates it fresh with this one connection as default.
 * - **Already exists**: refuses to touch it, and instead returns a ready-to-
 *   paste `<database>` XML snippet plus the file it belongs in.
 *
 * Either way, also reminds the caller that `core.use_database = true` needs
 * to be set in `Config/settings.*` (another existing file this tool won't edit).
 */
final class ScaffoldDbConnection
{
    /**
     * Maps a driver name to its adapter's real FQCN -- written directly into
     * `class="..."`, never a short alias. Aliases like `doctrine_dbal` are
     * only registered by that adapter's own plugin
     * ({@see \Quiote\Database\Adapter\Doctrine\DoctrinePlugin} etc.) *if*
     * it's enabled in the target app's `plugins` config, which this tool has
     * no way to confirm -- the FQCN always resolves as long as the package
     * is installed, regardless of plugin registration order.
     */
    private const DRIVER_CLASSES = [
        'pdo' => 'Quiote\\Database\\PdoDatabase',
        'eloquent' => 'Quiote\\Database\\Adapter\\Eloquent\\EloquentDatabase',
        'doctrine' => 'Quiote\\Database\\Adapter\\Doctrine\\DoctrineDatabase',
        'doctrine_dbal' => 'Quiote\\Database\\Adapter\\Doctrine\\DoctrineDbalDatabase',
        'cycle' => 'Quiote\\Database\\Adapter\\Cycle\\CycleDatabase',
    ];

    /** @return array<string, mixed> */
    public static function run(string $appDir, string $name, string $driver, bool $dryRun): array
    {
        ScaffoldTemplates::assertValidName(ucfirst($name), 'connection'); // reuse the PascalCase check loosely; connection names are usually lowercase
        $driver = strtolower($driver);
        if (!isset(self::DRIVER_CLASSES[$driver])) {
            throw new \InvalidArgumentException(sprintf(
                'Unknown driver "%s". Expected one of: %s.',
                $driver,
                implode(', ', array_keys(self::DRIVER_CLASSES)),
            ));
        }

        $configDir = rtrim(Config::getString('core.config_dir'), '/');
        $path = "{$configDir}/databases.xml";
        $entry = self::entryXml($name, $driver);

        if (is_file($path)) {
            return [
                'connection' => $name,
                'driver' => $driver,
                'status' => 'exists_manual_edit_required',
                'file' => 'Config/databases.xml',
                'snippet' => $entry,
                'next_step' => 'Paste the snippet inside the existing <databases> element in Config/databases.xml, and set core.use_database = true in Config/settings.* if not already set.',
            ];
        }

        $content = self::fullDocument($name, $entry);
        $result = ScaffoldWriter::apply($appDir, [['path' => $path, 'content' => $content]], $dryRun);

        return array_merge($result, [
            'connection' => $name,
            'driver' => $driver,
            'next_step' => 'Set core.use_database = true in Config/settings.* to enable it.',
        ]);
    }

    private static function entryXml(string $name, string $driver): string
    {
        $class = self::DRIVER_CLASSES[$driver];

        return <<<XML
                <database name="{$name}" class="{$class}">
                    <ae:parameter name="dsn">sqlite::memory:</ae:parameter>
                </database>

            XML;
    }

    /** Matches this app's own Config/databases.xml exactly (envelope + parts namespaces, `ae:` prefix). */
    private static function fullDocument(string $name, string $entry): string
    {
        return <<<XML
            <?xml version="1.0" encoding="UTF-8"?>
            <ae:configurations xmlns:ae="http://quiote.dev/quiote/config/global/envelope/1.1" xmlns="http://quiote.dev/quiote/config/parts/databases/1.1">
                <ae:configuration>
                    <databases default="{$name}">
            {$entry}
                    </databases>
                </ae:configuration>
            </ae:configurations>

            XML;
    }
}
