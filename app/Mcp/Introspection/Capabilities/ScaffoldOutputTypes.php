<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Introspection\Capabilities;

use Quiote\Config\OutputTypeConfigHandler;
use Quiote\Config\XmlConfigParser;
use QuioteMcpAssistant\Mcp\Support\Cfg;

/**
 * Read-only helper for `scaffold_action`'s `formats` support: which of the
 * requested output types (`html`, `json`, …) are already declared in the
 * target app's `Config/output_types.xml`, parsed through the same
 * `XmlConfigParser` + `output_types.xsl` + {@see OutputTypeConfigHandler::toCanonicalArray()}
 * pipeline the framework's own `OutputTypeManager` compiles at boot.
 *
 * `scaffold_action` never edits `Config/output_types.xml` itself (that file
 * always exists in a real app -- unlike `databases.xml` -- so there's no
 * "create it fresh" case, only "already exists"); a requested format that
 * isn't declared yet is reported back as a ready-to-paste snippet instead,
 * the same never-touch-an-existing-file guarantee every other scaffold tool
 * makes (see {@see ScaffoldWriter}).
 */
final class ScaffoldOutputTypes
{
    /** @return list<string> every output type name already declared, or [] if the config file doesn't exist/parse */
    public static function declared(): array
    {
        $configDir = rtrim(Cfg::string('core.config_dir'), '/');
        $path = "{$configDir}/output_types.xml";
        if (!is_file($path)) {
            return [];
        }

        try {
            // Unlike databases.xml (already the 1.1 envelope in a fresh app),
            // output_types.xml still ships in the legacy 1.0 namespace, so it
            // needs two hops through the same stylesheet to reach the 1.1
            // shape OutputTypeConfigHandler expects -- config_handlers.xml
            // lists this same transformation twice for exactly that reason.
            $outputTypesXsl = Cfg::string('core.quiote_dir') . '/Config/xsl/output_types.xsl';
            $document = XmlConfigParser::run(
                $path,
                Cfg::string('core.environment'),
                '',
                [
                    XmlConfigParser::STAGE_SINGLE => [$outputTypesXsl, $outputTypesXsl],
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

            $canonical = (new OutputTypeConfigHandler())->toCanonicalArray($document);

            return array_map('strval', array_keys($canonical['output_types']));
        } catch (\Throwable) {
            // A config file that doesn't parse is not this tool's problem to
            // report -- scaffold_action still succeeds, just without being
            // able to tell whether the requested formats are declared.
            return [];
        }
    }

    /** A ready-to-paste `<output_type>` snippet for a format that isn't declared yet. */
    public static function snippet(string $format): string
    {
        $contentType = self::CONTENT_TYPES[$format] ?? 'text/plain; charset=UTF-8';

        return <<<XML
                <output_type name="{$format}">
                    <renderers default="php">
                        <renderer name="php" class="Quiote\\Renderer\\PhpRenderer" />
                    </renderers>
                    <parameter name="http_headers">
                        <parameter name="Content-Type">{$contentType}</parameter>
                    </parameter>
                </output_type>

            XML;
    }

    private const CONTENT_TYPES = [
        'html' => 'text/html; charset=UTF-8',
        'json' => 'application/json; charset=UTF-8',
        'xml' => 'application/xml; charset=UTF-8',
        'csv' => 'text/csv; charset=UTF-8',
        'text' => 'text/plain; charset=UTF-8',
    ];
}
