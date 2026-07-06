<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Console;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Bundles the authoritative Quiote documentation as this app's MCP resources.
 *
 * The real docs live in a *sibling* Starlight (Astro) repo -- not a runtime
 * dependency of this app -- so this is a re-runnable build step, not a one-off
 * copy: re-run it whenever the docs site changes. For each `*.{md,mdx}` under
 * the source tree it (a) reads `title`/`description` from Starlight frontmatter,
 * (b) drops the `import { ... } from '@astrojs/starlight/components'` line, and
 * (c) unwraps the only four custom components the site uses -- `Tabs`/`TabItem`
 * and `CardGrid`/`Card` -- to plain Markdown (a `label`/`title` attribute
 * becomes a `####` sub-heading, inner content is kept). The result is written
 * to `Mcp/Resources/docs/<relpath>.md`, one file per doc, and an index is
 * regenerated at `Mcp/Resources/manifest.php` keyed by the MCP resource URI
 * (`quiote-docs://<relpath-without-extension>`), which {@see \QuioteMcpAssistant\Mcp\AssistantPlugin}
 * reads to register one MCP resource per doc.
 *
 * This command needs no bootstrapped Quiote app (it only touches files), so it
 * extends the plain Symfony `Command`; it is contributed to the console by the
 * assistant plugin like any other plugin command.
 */
#[AsCommand(name: 'mcp:docs:sync', description: 'Sync the Quiote docs site into this app as bundled MCP resources')]
final class DocsSyncCommand extends Command
{
    /**
     * Top-level source directories to skip entirely -- sibling
     * quioteframework projects with their own dedicated MCP server (and
     * their own doc-sync) that happen to share this same Starlight site.
     *
     * @var list<string>
     */
    private const EXCLUDED_TOP_LEVEL_DIRS = ['propulsion'];

    protected function configure(): void
    {
        $this->addOption(
            'source',
            null,
            InputOption::VALUE_REQUIRED,
            'Path to the Starlight docs root (the directory holding getting-started/, basics/, ...)',
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $sourceOption = $input->getOption('source');
        $source = is_string($sourceOption) ? $sourceOption : '';
        if ($source === '') {
            $io->error('The --source option is required: pass the path to the Starlight docs root (the directory holding getting-started/, basics/, ...).');
            return self::FAILURE;
        }

        $source = rtrim($source, '/');
        $real = realpath($source);
        if ($real === false || !is_dir($real)) {
            $io->error(sprintf('Docs source directory "%s" does not exist.', $source));
            return self::FAILURE;
        }

        $outDir = dirname(__DIR__) . '/Resources/docs';
        $manifestFile = dirname(__DIR__) . '/Resources/manifest.php';

        $this->resetOutputDir($outDir);

        /** @var list<string> $files */
        $files = [];
        $dirIterator = new \RecursiveCallbackFilterIterator(
            new \RecursiveDirectoryIterator($real, \FilesystemIterator::SKIP_DOTS),
            static fn (\SplFileInfo $file): bool => !$file->isDir()
                || !in_array(strtolower($file->getFilename()), self::EXCLUDED_TOP_LEVEL_DIRS, true)
                || dirname($file->getPathname()) !== $real,
        );
        $it = new \RecursiveIteratorIterator($dirIterator);
        foreach ($it as $file) {
            /** @var \SplFileInfo $file */
            if ($file->isFile() && in_array(strtolower($file->getExtension()), ['md', 'mdx'], true)) {
                $files[] = $file->getPathname();
            }
        }
        sort($files);

        $manifest = [];
        $skipped = [];
        foreach ($files as $path) {
            $relDir = ltrim(substr($path, strlen($real)), '/');           // e.g. basics/routing.mdx
            $relKey = preg_replace('/\.(md|mdx)$/i', '', $relDir) ?? $relDir;         // e.g. basics/routing

            $raw = file_get_contents($path);
            if ($raw === false) {
                $io->warning(sprintf('Could not read %s -- skipping.', $relDir));
                continue;
            }

            [$frontmatter, $body] = $this->splitFrontmatter($raw);

            // Splash / landing pages are navigation chrome, not knowledge.
            if (($frontmatter['template'] ?? null) === 'splash') {
                $skipped[] = $relKey;
                continue;
            }

            $title = $frontmatter['title'] ?? $this->titleFromKey($relKey);
            $description = $frontmatter['description'] ?? '';

            $markdown = $this->toPlainMarkdown($title, $description, $body);

            $outPath = $outDir . '/' . $relKey . '.md';
            $this->ensureDir(dirname($outPath));
            file_put_contents($outPath, $markdown);

            $uri = 'quiote-docs://' . $relKey;
            $manifest[$uri] = [
                'file' => $relKey . '.md',
                'path' => $relKey,
                'title' => $title,
                'description' => $description,
            ];
        }

        ksort($manifest);
        $this->writeManifest($manifestFile, $manifest);

        $io->success(sprintf(
            'Synced %d docs into %s (skipped %d splash page(s)).',
            count($manifest),
            $outDir,
            count($skipped),
        ));
        if ($skipped !== []) {
            $io->writeln('  <comment>skipped:</comment> ' . implode(', ', $skipped));
        }

        return self::SUCCESS;
    }

    /**
     * Split a Starlight file into [frontmatter, body]. Frontmatter is a leading
     * `---`-delimited block of simple `key: value` lines (quotes trimmed) --
     * enough for `title`/`description`/`template`, which is all we consume.
     *
     * @return array{0: array<string, string>, 1: string}
     */
    private function splitFrontmatter(string $raw): array
    {
        $raw = preg_replace('/^\xEF\xBB\xBF/', '', $raw) ?? $raw; // strip BOM
        if (!preg_match('/^---\r?\n(.*?)\r?\n---\r?\n?(.*)$/s', $raw, $m)) {
            return [[], $raw];
        }

        $frontmatter = [];
        foreach (preg_split('/\r?\n/', $m[1]) ?: [] as $line) {
            if (preg_match('/^([A-Za-z0-9_-]+):\s*(.*)$/', $line, $kv)) {
                $value = trim($kv[2]);
                $value = trim($value, "'\"");
                $frontmatter[$kv[1]] = $value;
            }
        }

        return [$frontmatter, $m[2]];
    }

    /**
     * Strip the Starlight component import and unwrap the four custom components
     * the site uses into plain Markdown, then prepend a title heading + the
     * frontmatter description as a lead paragraph.
     */
    private function toPlainMarkdown(string $title, string $description, string $body): string
    {
        // Drop the `import { ... } from '@astrojs/starlight/components';` line(s).
        $body = preg_replace(
            "/^\s*import\s+\{[^}]*\}\s+from\s+['\"]@astrojs\/starlight\/components['\"];?\s*$/m",
            '',
            $body,
        ) ?? $body;

        // <TabItem label="X"> / <Card title="X"> carry a heading-worthy label.
        $body = preg_replace('/<TabItem\b[^>]*\blabel="([^"]*)"[^>]*>/', "\n#### $1\n", $body) ?? $body;
        $body = preg_replace('/<Card\b[^>]*\btitle="([^"]*)"[^>]*>/', "\n#### $1\n", $body) ?? $body;

        // Remaining structural component tags carry no content -- unwrap them.
        $body = preg_replace('/<\/?(?:Tabs|TabItem|CardGrid|Card)\b[^>]*>/', '', $body) ?? $body;

        // Collapse the blank lines the unwrapping leaves behind.
        $body = preg_replace('/\n{3,}/', "\n\n", $body) ?? $body;
        $body = trim($body);

        $header = '# ' . $title . "\n";
        if ($description !== '') {
            $header .= "\n> " . $description . "\n";
        }

        return $header . "\n" . $body . "\n";
    }

    private function titleFromKey(string $key): string
    {
        $leaf = basename($key);
        return ucwords(str_replace('-', ' ', $leaf));
    }

    private function resetOutputDir(string $dir): void
    {
        if (is_dir($dir)) {
            $it = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($dir, \FilesystemIterator::SKIP_DOTS),
                \RecursiveIteratorIterator::CHILD_FIRST,
            );
            foreach ($it as $entry) {
                /** @var \SplFileInfo $entry */
                $entry->isDir() ? @rmdir($entry->getPathname()) : @unlink($entry->getPathname());
            }
        }
        $this->ensureDir($dir);
    }

    private function ensureDir(string $dir): void
    {
        if (!is_dir($dir)) {
            mkdir($dir, 0o775, true);
        }
    }

    /** @param array<string, array{file: string, path: string, title: string, description: string}> $manifest */
    private function writeManifest(string $file, array $manifest): void
    {
        $export = var_export($manifest, true);
        $php = "<?php\n\n"
            . "/**\n"
            . " * GENERATED by `mcp:docs:sync` -- do not edit by hand.\n"
            . " * Maps each MCP resource URI to its bundled file + frontmatter metadata.\n"
            . " */\n\n"
            . "return {$export};\n";
        file_put_contents($file, $php);
    }
}
