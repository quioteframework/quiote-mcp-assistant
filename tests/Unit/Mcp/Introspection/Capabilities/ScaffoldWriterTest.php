<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Unit\Mcp\Introspection\Capabilities;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use QuioteMcpAssistant\Mcp\Introspection\Capabilities\ScaffoldWriter;

/**
 * ScaffoldWriter is the one thing standing between "an agent can generate
 * code" and "an agent can silently clobber a developer's existing file" --
 * every guarantee here is tested against a real filesystem, not mocked,
 * since a mock could trivially hide a real bug in the actual is_file()/
 * file_put_contents() calls this class makes.
 */
final class ScaffoldWriterTest extends TestCase
{
    private string $appDir;

    protected function setUp(): void
    {
        $this->appDir = sys_get_temp_dir() . '/scaffold-writer-test-' . bin2hex(random_bytes(8));
        mkdir($this->appDir, 0o775, true);
    }

    protected function tearDown(): void
    {
        $this->removeDirectory($this->appDir);
    }

    #[Test]
    public function dryRunWritesNothingToDisk(): void
    {
        $path = "{$this->appDir}/Modules/Blog/Actions/IndexAction.php";

        $result = ScaffoldWriter::apply($this->appDir, [['path' => $path, 'content' => '<?php // test']], true);

        self::assertTrue($result['dry_run']);
        self::assertSame('would_create', $result['files'][0]['status']);
        self::assertFileDoesNotExist($path);
    }

    #[Test]
    public function dryRunReportsAUnifiedDiffOfTheWouldBeFile(): void
    {
        $path = "{$this->appDir}/Modules/Blog/Actions/IndexAction.php";

        $result = ScaffoldWriter::apply($this->appDir, [['path' => $path, 'content' => "<?php\necho 'hi';\n"]], true);

        $diff = $result['files'][0]['diff'] ?? null;
        self::assertNotNull($diff, 'Dry-run result is missing a diff.');
        self::assertStringStartsWith('--- /dev/null', $diff);
        self::assertStringContainsString('+++ b/Modules/Blog/Actions/IndexAction.php', $diff);
        self::assertStringContainsString("+<?php\n", $diff);
        self::assertStringContainsString("+echo 'hi';\n", $diff);
    }

    #[Test]
    public function realWriteActuallyCreatesTheFileWithExactContent(): void
    {
        $path = "{$this->appDir}/Modules/Blog/Actions/IndexAction.php";
        $content = "<?php\n// generated\n";

        $result = ScaffoldWriter::apply($this->appDir, [['path' => $path, 'content' => $content]], false);

        self::assertSame('created', $result['files'][0]['status']);
        self::assertFileExists($path);
        self::assertSame($content, file_get_contents($path));
    }

    #[Test]
    public function reportsFailedMkdirWhenTheParentDirectoryCannotBeCreated(): void
    {
        $restrictedDir = "{$this->appDir}/restricted";
        mkdir($restrictedDir, 0o555, true); // read+execute only -- no write permission
        $path = "{$restrictedDir}/Nested/IndexAction.php";

        try {
            $result = ScaffoldWriter::apply($this->appDir, [['path' => $path, 'content' => '<?php']], false);

            self::assertSame('failed_mkdir', $result['files'][0]['status']);
            self::assertFileDoesNotExist($path);
        } finally {
            chmod($restrictedDir, 0o775); // tearDown's recursive delete needs write permission restored
        }
    }

    #[Test]
    public function reportsFailedWriteWhenThePathIsAlreadyADirectory(): void
    {
        // is_file() is false for a directory, so this passes the
        // never-overwrite check and reaches file_put_contents(), which
        // can't write file content to a path that's actually a directory.
        $path = "{$this->appDir}/IndexAction.php";
        mkdir($path, 0o775, true);

        $result = ScaffoldWriter::apply($this->appDir, [['path' => $path, 'content' => '<?php']], false);

        self::assertSame('failed_write', $result['files'][0]['status']);
    }

    #[Test]
    public function realWriteCreatesMissingParentDirectories(): void
    {
        $path = "{$this->appDir}/Modules/Blog/Actions/Nested/Deep/IndexAction.php";

        ScaffoldWriter::apply($this->appDir, [['path' => $path, 'content' => '<?php']], false);

        self::assertFileExists($path);
    }

    #[Test]
    public function neverOverwritesAnExistingFileInWriteMode(): void
    {
        $path = "{$this->appDir}/Modules/Blog/Actions/IndexAction.php";
        mkdir(dirname($path), 0o775, true);
        file_put_contents($path, 'original content');

        $result = ScaffoldWriter::apply($this->appDir, [['path' => $path, 'content' => 'new content']], false);

        self::assertSame('skipped_exists', $result['files'][0]['status']);
        self::assertSame('original content', file_get_contents($path));
    }

    #[Test]
    public function neverOverwritesAnExistingFileInDryRunEither(): void
    {
        $path = "{$this->appDir}/Modules/Blog/Actions/IndexAction.php";
        mkdir(dirname($path), 0o775, true);
        file_put_contents($path, 'original content');

        $result = ScaffoldWriter::apply($this->appDir, [['path' => $path, 'content' => 'new content']], true);

        self::assertSame('skipped_exists', $result['files'][0]['status']);
        self::assertArrayNotHasKey('diff', $result['files'][0]);
        self::assertSame('original content', file_get_contents($path));
    }

    #[Test]
    public function reportsPathsRelativeToTheAppDir(): void
    {
        $path = "{$this->appDir}/Modules/Blog/Actions/IndexAction.php";

        $result = ScaffoldWriter::apply($this->appDir, [['path' => $path, 'content' => '<?php']], true);

        self::assertSame('Modules/Blog/Actions/IndexAction.php', $result['files'][0]['path']);
    }

    #[Test]
    public function handlesMultipleFilesIndependently(): void
    {
        $existing = "{$this->appDir}/Existing.php";
        file_put_contents($existing, 'already here');
        $new = "{$this->appDir}/New.php";

        $result = ScaffoldWriter::apply($this->appDir, [
            ['path' => $existing, 'content' => 'ignored'],
            ['path' => $new, 'content' => '<?php'],
        ], false);

        self::assertSame('skipped_exists', $result['files'][0]['status']);
        self::assertSame('created', $result['files'][1]['status']);
    }

    private function removeDirectory(string $dir): void
    {
        if (!is_dir($dir)) {
            return;
        }
        $items = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir, \FilesystemIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST,
        );
        foreach ($items as $item) {
            /** @var \SplFileInfo $item */
            $item->isDir() ? rmdir($item->getPathname()) : unlink($item->getPathname());
        }
        rmdir($dir);
    }
}
