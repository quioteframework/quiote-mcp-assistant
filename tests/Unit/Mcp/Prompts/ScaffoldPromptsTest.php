<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Unit\Mcp\Prompts;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use QuioteMcpAssistant\Mcp\Prompts\ScaffoldPrompts;

final class ScaffoldPromptsTest extends TestCase
{
    private ScaffoldPrompts $prompts;

    protected function setUp(): void
    {
        $this->prompts = new ScaffoldPrompts();
    }

    #[Test]
    public function newModuleInterpolatesTheModuleNameAndCitesConventions(): void
    {
        $messages = $this->prompts->newModule('Blog');

        self::assertSame('user', $messages[0]['role']);
        self::assertStringContainsString('named "Blog"', $messages[0]['content']);
        self::assertStringContainsString('Modules/Blog/Actions/IndexAction.php', $messages[0]['content']);
        self::assertStringContainsString('Relevant Quiote conventions', $messages[0]['content']);
    }

    #[Test]
    public function newModuleDefaultsToBlog(): void
    {
        $messages = $this->prompts->newModule();

        self::assertStringContainsString('named "Blog"', $messages[0]['content']);
    }

    #[Test]
    public function addActionInterpolatesModuleNameAndVerbs(): void
    {
        $messages = $this->prompts->addAction('Blog', 'Post', 'read,write');

        self::assertStringContainsString('action "Post" to module "Blog"', $messages[0]['content']);
        self::assertStringContainsString('handling the verb(s): read,write', $messages[0]['content']);
    }

    #[Test]
    public function addServiceMapsEachScopeToItsContainerConstant(): void
    {
        self::assertStringContainsString('Container::SCOPE_SINGLETON', $this->prompts->addService('X', 'singleton')[0]['content']);
        self::assertStringContainsString('Container::SCOPE_REQUEST', $this->prompts->addService('X', 'request')[0]['content']);
        self::assertStringContainsString('Container::SCOPE_TRANSIENT', $this->prompts->addService('X', 'transient')[0]['content']);
        // Anything unrecognized falls back to transient rather than emitting a bogus constant name.
        self::assertStringContainsString('Container::SCOPE_TRANSIENT', $this->prompts->addService('X', 'made-up-scope')[0]['content']);
    }

    #[Test]
    public function addPluginInterpolatesThePluginName(): void
    {
        $messages = $this->prompts->addPlugin('Health');

        self::assertStringContainsString('plugin "Health"', $messages[0]['content']);
        self::assertStringContainsString('Health::class', $messages[0]['content']);
    }

    #[Test]
    public function addDbConnectionInterpolatesNameAndDriver(): void
    {
        $messages = $this->prompts->addDbConnection('main', 'eloquent');

        self::assertStringContainsString('named "main" using the "eloquent" adapter', $messages[0]['content']);
    }

    #[Test]
    public function exposeMcpToolInterpolatesTheActionReference(): void
    {
        $messages = $this->prompts->exposeMcpTool('Blog.Post');

        self::assertStringContainsString('action "Blog.Post"', $messages[0]['content']);
        self::assertStringContainsString('McpTool', $messages[0]['content']);
    }
}
