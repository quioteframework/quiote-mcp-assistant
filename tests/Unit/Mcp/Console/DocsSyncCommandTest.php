<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Unit\Mcp\Console;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use QuioteMcpAssistant\Mcp\Console\DocsSyncCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * `mcp:docs:sync`'s output paths (`Resources/docs`, `Resources/manifest.php`)
 * are hardcoded relative to its own class file, not injectable, so every
 * real invocation touches this repo's own bundled docs. setUp/tearDown
 * snapshot and restore them around each test so a test run never leaves the
 * committed docs/manifest altered on disk.
 */
final class DocsSyncCommandTest extends TestCase
{
    private string $docsDir;
    private string $manifestFile;
    private string $backupDocsDir;
    private string $backupManifestFile;
    private string $fixtureSource;

    protected function setUp(): void
    {
        $resourcesDir = dirname(__DIR__, 4) . '/app/Mcp/Resources';
        $this->docsDir = $resourcesDir . '/docs';
        $this->manifestFile = $resourcesDir . '/manifest.php';

        $unique = uniqid('docs-sync-test-', true);
        $this->backupDocsDir = sys_get_temp_dir() . '/' . $unique . '-docs-backup';
        $this->backupManifestFile = sys_get_temp_dir() . '/' . $unique . '-manifest-backup.php';
        $this->fixtureSource = sys_get_temp_dir() . '/' . $unique . '-source';

        $this->copyDir($this->docsDir, $this->backupDocsDir);
        copy($this->manifestFile, $this->backupManifestFile);

        mkdir($this->fixtureSource . '/basics', 0o775, true);
        mkdir($this->fixtureSource . '/propulsion/nested', 0o775, true);
        file_put_contents(
            $this->fixtureSource . '/basics/routing.md',
            "---\ntitle: Routing\ndescription: Test doc\n---\nSome content.\n",
        );
        file_put_contents(
            $this->fixtureSource . '/basics/landing.md',
            "---\ntitle: Landing\ntemplate: splash\n---\nNavigation chrome, not knowledge.\n",
        );
        file_put_contents(
            $this->fixtureSource . '/basics/untitled.md',
            "No frontmatter at all.\n",
        );
        file_put_contents(
            $this->fixtureSource . '/propulsion/schema.md',
            "---\ntitle: Propulsion Schema\n---\nShould be excluded.\n",
        );
        file_put_contents(
            $this->fixtureSource . '/propulsion/nested/deep.md',
            "---\ntitle: Deep Propulsion Doc\n---\nShould also be excluded.\n",
        );
    }

    protected function tearDown(): void
    {
        $this->removeDir($this->docsDir);
        $this->copyDir($this->backupDocsDir, $this->docsDir);
        $this->removeDir($this->backupDocsDir);

        copy($this->backupManifestFile, $this->manifestFile);
        unlink($this->backupManifestFile);

        $this->removeDir($this->fixtureSource);
    }

    #[Test]
    public function excludesTheTopLevelPropulsionDirectoryEntirely(): void
    {
        $tester = $this->runSync();

        self::assertSame(Command::SUCCESS, $tester->getStatusCode());
        self::assertFileDoesNotExist($this->docsDir . '/propulsion');

        foreach (array_keys($this->readManifest()) as $uri) {
            self::assertStringNotContainsStringIgnoringCase('propulsion', $uri);
        }
    }

    #[Test]
    public function bundlesADocWithItsFrontmatterTitleAndDescription(): void
    {
        $this->runSync();

        $manifest = $this->readManifest();
        self::assertArrayHasKey('quiote-docs://basics/routing', $manifest);
        self::assertSame('Routing', $manifest['quiote-docs://basics/routing']['title']);
        self::assertSame('Test doc', $manifest['quiote-docs://basics/routing']['description']);
        self::assertFileExists($this->docsDir . '/basics/routing.md');
    }

    #[Test]
    public function skipsSplashTemplatePages(): void
    {
        $this->runSync();

        self::assertArrayNotHasKey('quiote-docs://basics/landing', $this->readManifest());
        self::assertFileDoesNotExist($this->docsDir . '/basics/landing.md');
    }

    #[Test]
    public function derivesATitleFromTheFileNameWhenFrontmatterHasNone(): void
    {
        $this->runSync();

        self::assertSame('Untitled', $this->readManifest()['quiote-docs://basics/untitled']['title']);
    }

    #[Test]
    public function requiresTheSourceOption(): void
    {
        $application = new Application();
        $application->addCommand(new DocsSyncCommand());
        $tester = new CommandTester($application->find('mcp:docs:sync'));

        $tester->execute([]);

        self::assertSame(Command::FAILURE, $tester->getStatusCode());
        self::assertStringContainsString('--source option is required', $tester->getDisplay());
    }

    #[Test]
    public function rejectsANonexistentSourceDirectory(): void
    {
        $application = new Application();
        $application->addCommand(new DocsSyncCommand());
        $tester = new CommandTester($application->find('mcp:docs:sync'));

        $tester->execute(['--source' => '/nonexistent/wherever']);

        self::assertSame(Command::FAILURE, $tester->getStatusCode());
        self::assertStringContainsString('does not exist', $tester->getDisplay());
    }

    private function runSync(): CommandTester
    {
        $application = new Application();
        $application->addCommand(new DocsSyncCommand());
        $tester = new CommandTester($application->find('mcp:docs:sync'));
        $tester->execute(['--source' => $this->fixtureSource]);

        return $tester;
    }

    /** @return array<string, array{file: string, path: string, title: string, description: string}> */
    private function readManifest(): array
    {
        /** @var array<string, array{file: string, path: string, title: string, description: string}> $manifest */
        $manifest = require $this->manifestFile;

        return $manifest;
    }

    private function copyDir(string $from, string $to): void
    {
        if (!is_dir($from)) {
            return;
        }

        mkdir($to, 0o775, true);
        $it = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($from, \FilesystemIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST,
        );
        foreach ($it as $item) {
            /** @var \SplFileInfo $item */
            $target = $to . '/' . substr($item->getPathname(), strlen($from) + 1);
            if ($item->isDir()) {
                if (!is_dir($target)) {
                    mkdir($target, 0o775, true);
                }
            } else {
                copy($item->getPathname(), $target);
            }
        }
    }

    private function removeDir(string $dir): void
    {
        if (!is_dir($dir)) {
            return;
        }

        $it = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir, \FilesystemIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST,
        );
        foreach ($it as $item) {
            /** @var \SplFileInfo $item */
            $item->isDir() ? rmdir($item->getPathname()) : unlink($item->getPathname());
        }
        rmdir($dir);
    }
}
