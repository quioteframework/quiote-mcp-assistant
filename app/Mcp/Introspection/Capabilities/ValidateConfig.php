<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Introspection\Capabilities;

use Quiote\Config\Config;
use Quiote\Config\ConfigCache;
use Quiote\Config\DatabaseConfigHandler;
use Quiote\Config\FactoryConfigHandler;
use Quiote\Config\Format\FormatDriverRegistry;
use Quiote\Config\Format\PositionAwareFormatDriverInterface;
use Quiote\Config\IArrayConfigHandler;
use Quiote\Config\ISchemaAwareConfigHandler;
use Quiote\Config\IXmlConfigHandler;
use Quiote\Config\MiddlewareConfigHandler;
use Quiote\Config\OutputTypeConfigHandler;
use Quiote\Config\PluginConfigHandler;
use Quiote\Config\RbacDefinitionConfigHandler;
use Quiote\Config\Schema\Diagnostic as SchemaDiagnostic;
use Quiote\Config\Schema\SchemaValidator;
use Quiote\Config\Schema\Severity as SchemaSeverity;
use Quiote\Config\SettingConfigHandler;
use Quiote\Config\TranslationConfigHandler;
use Quiote\Config\XmlConfigParser;
use Symfony\Component\Yaml\Exception\ParseException as YamlParseException;
use Symfony\Component\Yaml\Yaml;

/**
 * `validate_config` -- see VSCODE_EXTENSION_INTEGRATION.md §4/§5 item 4. Runs
 * the config validator's Layers 1 (syntax) + 2 (semantic, via the handler's
 * real compilation) + (b) (array-shape schema, for handlers that declare one)
 * against one logical config or all known ones, format-agnostically (PHP,
 * YAML, or XML -- whichever `core.config_format`/autodetect resolves), and
 * reports shadowed-config diagnostics (§3) alongside them.
 *
 * Deliberately mirrors {@see ListDbConnections}'s style of a hardcoded,
 * per-config-type table rather than reaching into `ConfigCache`'s protected
 * handler registry: the known app-level config types (and their XSD/handler
 * pairing) are a fixed, small set the framework itself hardcodes in
 * `Config/defaults/config_handlers.xml`, so duplicating that pairing here
 * needs no reflection or subclassing to reach non-public internals.
 *
 * Per-module configs (`module.xml`, `Validate/*.xml`) are out of scope --
 * this capability only covers the single-file, one-per-app config types.
 */
final class ValidateConfig
{
    /**
     * @var array<string, array{class: class-string<IArrayConfigHandler&IXmlConfigHandler>, xsl: ?string, xsd: string, required: bool}>
     */
    private const CONFIGS = [
        'settings' => ['class' => SettingConfigHandler::class, 'xsl' => 'settings.xsl', 'xsd' => 'settings.xsd', 'required' => true],
        'factories' => ['class' => FactoryConfigHandler::class, 'xsl' => 'factories.xsl', 'xsd' => 'factories.xsd', 'required' => false],
        'databases' => ['class' => DatabaseConfigHandler::class, 'xsl' => 'databases.xsl', 'xsd' => 'databases.xsd', 'required' => false],
        'output_types' => ['class' => OutputTypeConfigHandler::class, 'xsl' => 'output_types.xsl', 'xsd' => 'output_types.xsd', 'required' => false],
        'rbac_definitions' => ['class' => RbacDefinitionConfigHandler::class, 'xsl' => 'rbac_definitions.xsl', 'xsd' => 'rbac_definitions.xsd', 'required' => false],
        'translation' => ['class' => TranslationConfigHandler::class, 'xsl' => 'translation.xsl', 'xsd' => 'translation.xsd', 'required' => false],
        'plugins' => ['class' => PluginConfigHandler::class, 'xsl' => null, 'xsd' => 'plugins.xsd', 'required' => false],
        'middleware' => ['class' => MiddlewareConfigHandler::class, 'xsl' => null, 'xsd' => 'middleware.xsd', 'required' => false],
    ];

    /**
     * @return array{
     *     _schema_version: int,
     *     diagnostics: list<array{severity: string, code: string, message: string, file: ?string, line: ?int, endLine: ?int, column: ?int, keyPath: ?string}>,
     *     error?: string,
     * }
     */
    public static function run(string $key = ''): array
    {
        if ($key !== '' && !isset(self::CONFIGS[$key])) {
            return [
                '_schema_version' => 1,
                'diagnostics' => [],
                'error' => sprintf(
                    'Unknown config key "%s"; expected one of: %s',
                    $key,
                    implode(', ', array_keys(self::CONFIGS)),
                ),
            ];
        }

        $keys = $key !== '' ? [$key] : array_keys(self::CONFIGS);
        $configDir = rtrim(Config::getString('core.config_dir'), '/');

        $diagnostics = [];
        foreach ($keys as $name) {
            $diagnostics = [...$diagnostics, ...self::validateOne($name, $configDir, $key !== '')];
        }

        return ['_schema_version' => 1, 'diagnostics' => $diagnostics];
    }

    /**
     * @return list<array{severity: string, code: string, message: string, file: ?string, line: ?int, endLine: ?int, column: ?int, keyPath: ?string}>
     */
    private static function validateOne(string $name, string $configDir, bool $explicitlyRequested): array
    {
        $definition = self::CONFIGS[$name];
        $logicalPath = $configDir . '/' . $name . '.xml';

        $candidates = ConfigCache::describeConfigCandidates($logicalPath);
        $diagnostics = self::mapShadowedDiagnostics(ConfigCache::describeShadowedConfigDiagnostics($logicalPath));

        $winner = $candidates['winner'];
        if ($winner === null) {
            if ($definition['required'] || $explicitlyRequested) {
                $diagnostics[] = self::diagnostic('error', 'config.missing', sprintf('No "%s" config file found.', $name), $logicalPath);
            }

            return $diagnostics;
        }

        $syntax = self::checkSyntax($winner);
        if ($syntax !== []) {
            return [...$diagnostics, ...$syntax];
        }

        $handler = new $definition['class']();
        $handler->initialize(null, []);

        $quioteDir = rtrim(Config::getString('core.quiote_dir'), '/');
        // config_handlers.xml declares each of these XSLs twice (0.11->1.0,
        // then 1.0->1.1) -- same stylesheet, applied twice in sequence, is
        // what upgrades a legacy 0.11-namespaced document all the way to
        // 1.1 before validation runs; a single application only gets it to
        // 1.0 and validation against the 1.1 XSD then fails.
        $transformations = $definition['xsl'] !== null
            ? [$quioteDir . '/Config/xsl/' . $definition['xsl'], $quioteDir . '/Config/xsl/' . $definition['xsl']]
            : [];
        $validations = [
            XmlConfigParser::STAGE_SINGLE => [
                XmlConfigParser::STEP_TRANSFORMATIONS_AFTER => [
                    XmlConfigParser::VALIDATION_TYPE_XMLSCHEMA => [$quioteDir . '/Config/xsd/' . $definition['xsd']],
                ],
            ],
        ];

        $registry = FormatDriverRegistry::forHandler($handler, $transformations, $validations);
        $environment = Config::getNullableString('core.environment');

        try {
            $driver = $registry->resolve($winner);
            $result = $driver instanceof PositionAwareFormatDriverInterface
                ? $driver->loadWithPositions($winner, $environment)
                : ['data' => $registry->load($winner, $environment), 'positions' => []];
        } catch (\Throwable $e) {
            $diagnostics[] = self::diagnostic('error', 'config.parse_error', $e->getMessage(), $winner);

            return $diagnostics;
        }

        /** @var array<string, mixed> $data */
        $data = $result['data'];
        /** @var array<string, array{file: string, line: int}> $positions */
        $positions = $result['positions'];

        if ($handler instanceof ISchemaAwareConfigHandler) {
            foreach (SchemaValidator::validate($handler->schema(), $data) as $schemaDiagnostic) {
                $diagnostics[] = self::mapSchemaDiagnostic($schemaDiagnostic, $winner, $positions);
            }
        }

        try {
            $handler->executeArray($data, $winner);
        } catch (\Throwable $e) {
            $diagnostics[] = self::diagnostic('error', 'config.semantic_error', $e->getMessage(), $winner);
        }

        return $diagnostics;
    }

    /**
     * Layer 1 -- format-specific syntax check with a precise line number,
     * run before anything else touches the file: a syntax error makes
     * Layer 2/(b) meaningless (there is no canonical array to check).
     * @return list<array{severity: string, code: string, message: string, file: ?string, line: ?int, endLine: ?int, column: ?int, keyPath: ?string}>
     */
    private static function checkSyntax(string $path): array
    {
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        return match ($extension) {
            'php' => self::checkPhpSyntax($path),
            'yaml', 'yml' => self::checkYamlSyntax($path),
            'xml' => self::checkXmlSyntax($path),
            default => [],
        };
    }

    /** @return list<array{severity: string, code: string, message: string, file: ?string, line: ?int, endLine: ?int, column: ?int, keyPath: ?string}> */
    private static function checkPhpSyntax(string $path): array
    {
        $output = [];
        $exitCode = 0;
        exec('php -l ' . escapeshellarg($path) . ' 2>&1', $output, $exitCode);
        if ($exitCode === 0) {
            return [];
        }

        $message = implode("\n", $output);
        $line = null;
        if (preg_match('/on line (\d+)/', $message, $matches) === 1) {
            $line = (int) $matches[1];
        }

        return [self::diagnostic('error', 'config.syntax_error', $message, $path, $line)];
    }

    /** @return list<array{severity: string, code: string, message: string, file: ?string, line: ?int, endLine: ?int, column: ?int, keyPath: ?string}> */
    private static function checkYamlSyntax(string $path): array
    {
        try {
            Yaml::parseFile($path);
        } catch (YamlParseException $e) {
            return [self::diagnostic('error', 'config.syntax_error', $e->getMessage(), $path, $e->getParsedLine() > 0 ? $e->getParsedLine() : null)];
        }

        return [];
    }

    /** @return list<array{severity: string, code: string, message: string, file: ?string, line: ?int, endLine: ?int, column: ?int, keyPath: ?string}> */
    private static function checkXmlSyntax(string $path): array
    {
        $previous = libxml_use_internal_errors(true);
        libxml_clear_errors();

        $document = new \DOMDocument();
        $document->load($path);
        $errors = libxml_get_errors();

        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        if ($errors === []) {
            return [];
        }

        return array_map(
            static fn(\LibXMLError $error): array => self::diagnostic(
                $error->level === LIBXML_ERR_WARNING ? 'warning' : 'error',
                'config.syntax_error',
                trim($error->message),
                $path,
                $error->line > 0 ? $error->line : null,
                column: $error->column > 0 ? $error->column : null,
            ),
            $errors,
        );
    }

    /**
     * @param list<\Quiote\Support\Compiler\Diagnostic> $shadowed
     * @return list<array{severity: string, code: string, message: string, file: ?string, line: ?int, endLine: ?int, column: ?int, keyPath: ?string}>
     */
    private static function mapShadowedDiagnostics(array $shadowed): array
    {
        return array_map(
            static fn(\Quiote\Support\Compiler\Diagnostic $d): array => self::diagnostic(
                $d->severity,
                $d->code,
                $d->message,
                $d->where,
                $d->line,
                $d->endLine,
                $d->column,
            ),
            $shadowed,
        );
    }

    /**
     * @param array<string, array{file: string, line: int}> $positions
     * @return array{severity: string, code: string, message: string, file: ?string, line: ?int, endLine: ?int, column: ?int, keyPath: ?string}
     */
    private static function mapSchemaDiagnostic(SchemaDiagnostic $diagnostic, string $fallbackFile, array $positions): array
    {
        $position = $positions[$diagnostic->keyPath] ?? null;

        return self::diagnostic(
            $diagnostic->severity === SchemaSeverity::Error ? 'error' : 'warning',
            $diagnostic->code,
            $diagnostic->message,
            $position['file'] ?? $fallbackFile,
            $position['line'] ?? null,
            keyPath: $diagnostic->keyPath,
        );
    }

    /**
     * @return array{severity: string, code: string, message: string, file: ?string, line: ?int, endLine: ?int, column: ?int, keyPath: ?string}
     */
    private static function diagnostic(
        string $severity,
        string $code,
        string $message,
        ?string $file,
        ?int $line = null,
        ?int $endLine = null,
        ?int $column = null,
        ?string $keyPath = null,
    ): array {
        return [
            'severity' => $severity,
            'code' => $code,
            'message' => $message,
            'file' => $file,
            'line' => $line,
            'endLine' => $endLine,
            'column' => $column,
            'keyPath' => $keyPath,
        ];
    }
}
