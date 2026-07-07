<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Unit\Mcp;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Quiote\Config\Config;
use Quiote\Mcp\McpCatalog;
use Quiote\Plugin\PluginRegistrar;
use QuioteMcpAssistant\Mcp\AssistantPlugin;
use QuioteMcpAssistant\Mcp\Tools\ProjectInfoTool;
use QuioteMcpAssistant\Mcp\Tools\SearchDocsTool;

/**
 * `register()` is the one place every capability this app exposes is wired
 * up (manual registration -- see the class docblock for why). These tests
 * drive it against the real, process-wide {@see McpCatalog}, exactly as
 * `Quiote::bootstrap()` already does at process start -- {@see McpCatalog::reset()}
 * exists specifically for this.
 */
final class AssistantPluginTest extends TestCase
{
    private AssistantPlugin $plugin;

    protected function setUp(): void
    {
        $this->plugin = new AssistantPlugin();
        McpCatalog::reset();
        Config::remove('assistant.target_app_dir');
    }

    protected function tearDown(): void
    {
        // Restore the catalog to what real bootstrap already populated it
        // with, so no other test observes a half-reset process-global state.
        McpCatalog::reset();
        $this->plugin->register(new PluginRegistrar('quiote/assistant'));
        Config::remove('assistant.target_app_dir');
    }

    #[Test]
    public function carriesThePluginAttributeWithItsName(): void
    {
        // PluginInterface itself declares no name() -- PluginManager reads
        // #[Plugin]'s name argument instead (see the class docblock).
        $attributes = (new \ReflectionClass(AssistantPlugin::class))->getAttributes(\Quiote\Plugin\Attribute\Plugin::class);

        self::assertCount(1, $attributes);
        self::assertSame('quiote/assistant', $attributes[0]->newInstance()->name);
    }

    #[Test]
    public function registersTheKnowledgeToolsResourcesAndPromptsWithNoTargetConfigured(): void
    {
        $this->plugin->register(new PluginRegistrar('quiote/assistant'));

        $names = array_column(McpCatalog::tools(), 'name');
        self::assertSame(
            ['search_docs', 'get_convention', 'get_recipe', 'describe_symbol', 'list_api'],
            $names,
        );
        self::assertNotEmpty(McpCatalog::resources());
        self::assertCount(6, McpCatalog::prompts());
    }

    #[Test]
    public function bundlesTheHandlerClassAndMethodForATool(): void
    {
        $this->plugin->register(new PluginRegistrar('quiote/assistant'));

        $tool = McpCatalog::tools()[0];
        self::assertSame([SearchDocsTool::class, 'search'], $tool['handler']);
        self::assertSame('search_docs', $tool['name']);
    }

    #[Test]
    public function alsoRegistersProjectAwareToolsWhenATargetIsConfigured(): void
    {
        Config::set('assistant.target_app_dir', dirname(__DIR__, 3) . '/app');

        $this->plugin->register(new PluginRegistrar('quiote/assistant'));

        $names = array_column(McpCatalog::tools(), 'name');
        self::assertContains('project_info', $names);
        self::assertContains('run_console', $names);
        self::assertContains('scaffold_db_connection', $names);

        $projectInfoTool = array_values(array_filter(
            McpCatalog::tools(),
            static fn (array $tool): bool => $tool['name'] === 'project_info',
        ))[0];
        self::assertSame([ProjectInfoTool::class, 'info'], $projectInfoTool['handler']);
    }

    #[Test]
    public function omitsProjectAwareToolsWhenTheTargetIsBlank(): void
    {
        Config::set('assistant.target_app_dir', '   ');

        $this->plugin->register(new PluginRegistrar('quiote/assistant'));

        self::assertNotContains('project_info', array_column(McpCatalog::tools(), 'name'));
    }

    #[Test]
    public function setsConfigDefaultsWithoutOverwritingAnAlreadyConfiguredValue(): void
    {
        Config::set('mcp.server_name', 'custom-name', overwrite: true);

        $this->plugin->register(new PluginRegistrar('quiote/assistant'));

        self::assertSame('custom-name', Config::getString('mcp.server_name'));
    }
}
