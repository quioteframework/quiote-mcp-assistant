<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Unit\Mcp\Introspection\Capabilities;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use QuioteMcpAssistant\Mcp\Introspection\Capabilities\ScaffoldTemplates;

/**
 * ScaffoldTemplates generates real PHP source that ends up in a user's
 * project -- a real bug slipped through here earlier (the generated view
 * omitted View::execute(), which is abstract, so the class fatally failed
 * to instantiate the moment a scaffolded action actually ran) and was only
 * caught by booting a scratch app and hitting it over HTTP, not by eyeballing
 * the generated string. `assertValidPhp()` below runs every generated file
 * through the real PHP parser (`php -l`) so that class of bug fails a test
 * instead of needing a live app to surface.
 */
final class ScaffoldTemplatesTest extends TestCase
{
    #[Test]
    public function assertValidNameAcceptsPascalCase(): void
    {
        ScaffoldTemplates::assertValidName('Blog', 'module');
        ScaffoldTemplates::assertValidName('Post', 'action');
        $this->addToAssertionCount(1); // no exception thrown
    }

    #[Test]
    public function assertValidNameRejectsNonPascalCase(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        ScaffoldTemplates::assertValidName('blog', 'module');
    }

    #[Test]
    public function actionContentGeneratesValidPhp(): void
    {
        $content = ScaffoldTemplates::actionContent('App', 'Blog', 'Post', ['read', 'write']);

        self::assertValidPhp($content);
        self::assertStringContainsString('namespace App\\Modules\\Blog\\Actions;', $content);
        self::assertStringContainsString('class PostAction extends Action', $content);
        self::assertStringContainsString('public function executeRead(WebRequest $rd)', $content);
        self::assertStringContainsString('public function executeWrite(WebRequest $rd)', $content);
    }

    #[Test]
    public function actionContentRoutesIndexToTheModuleRootPath(): void
    {
        $content = ScaffoldTemplates::actionContent('App', 'Blog', 'Index', ['read']);

        self::assertStringContainsString("#[Route(path: '/blog')]", $content);
    }

    #[Test]
    public function actionContentRoutesNonIndexActionsUnderTheModulePath(): void
    {
        $content = ScaffoldTemplates::actionContent('App', 'Blog', 'Post', ['read']);

        self::assertStringContainsString("#[Route(path: '/blog/post')]", $content);
    }

    #[Test]
    public function viewContentAlwaysImplementsTheAbstractExecuteMethod(): void
    {
        // Regression test: View::execute() is abstract and must always be
        // implemented, even though every requested format below gets its
        // own more-specific execute<Format>() method the framework
        // dispatches to instead. Omitting this fatals at instantiation.
        $content = ScaffoldTemplates::viewContent('App', 'Blog', 'Index', ['html', 'json']);

        self::assertValidPhp($content);
        self::assertMatchesRegularExpression(
            '/public function execute\(WebRequest \$rd\): never/',
            $content,
        );
    }

    #[Test]
    public function viewContentGeneratesOneMethodPerRequestedFormat(): void
    {
        $content = ScaffoldTemplates::viewContent('App', 'Blog', 'Index', ['html', 'json']);

        self::assertValidPhp($content);
        self::assertStringContainsString('public function executeHtml(WebRequest $rd): void', $content);
        self::assertStringContainsString('$this->loadLayout();', $content);
        self::assertStringContainsString('public function executeJson(WebRequest $rd): string', $content);
        self::assertStringContainsString('json_encode(', $content);
    }

    #[Test]
    public function viewContentGeneratesAPlaceholderForAnUnknownFormat(): void
    {
        $content = ScaffoldTemplates::viewContent('App', 'Blog', 'Index', ['xml']);

        self::assertValidPhp($content);
        self::assertStringContainsString('public function executeXml(WebRequest $rd): string', $content);
    }

    #[Test]
    public function templateContentGeneratesValidPhp(): void
    {
        // A template file starts in HTML mode and switches into PHP inline,
        // so it's linted as its own standalone file content, not embedded
        // inside a class body.
        self::assertValidPhp(ScaffoldTemplates::templateContent('Index'));
    }

    private static function assertValidPhp(string $content): void
    {
        $tmpFile = tempnam(sys_get_temp_dir(), 'scaffold-template-test-');
        self::assertIsString($tmpFile);
        file_put_contents($tmpFile, $content);

        exec('php -l ' . escapeshellarg($tmpFile) . ' 2>&1', $output, $exitCode);
        unlink($tmpFile);

        self::assertSame(0, $exitCode, "Generated PHP is not valid:\n" . implode("\n", $output) . "\n\n---\n{$content}");
    }
}
