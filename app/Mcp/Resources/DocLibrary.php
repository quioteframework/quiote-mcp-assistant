<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Resources;

/**
 * Read-only accessor over the bundled documentation produced by `mcp:docs:sync`
 * (the `Resources/docs/**` files + `Resources/manifest.php` index). Shared by
 * {@see DocsResource} (serves a doc by URI) and
 * {@see \QuioteMcpAssistant\Mcp\Search\DocIndex} (searches across docs).
 *
 * Plain, dependency-free, and autowireable -- Quiote's DI container resolves it
 * with no configuration.
 */
final class DocLibrary
{
    /** @var array<string, array{file: string, path: string, title: string, description: string}>|null */
    private ?array $manifest = null;

    public function docsDir(): string
    {
        return __DIR__ . '/docs';
    }

    /** @return array<string, array{file: string, path: string, title: string, description: string}> */
    public function manifest(): array
    {
        if ($this->manifest === null) {
            $file = __DIR__ . '/manifest.php';
            /** @var array<string, array{file: string, path: string, title: string, description: string}> $loaded */
            $loaded = is_file($file) ? require $file : [];
            $this->manifest = $loaded;
        }

        return $this->manifest;
    }

    public function has(string $uri): bool
    {
        return isset($this->manifest()[$uri]);
    }

    /**
     * Return the raw Markdown for a doc URI, or null if unknown / unreadable.
     */
    public function body(string $uri): ?string
    {
        $meta = $this->manifest()[$uri] ?? null;
        if ($meta === null) {
            return null;
        }

        $path = $this->docsDir() . '/' . $meta['file'];
        $content = is_file($path) ? file_get_contents($path) : false;

        return $content === false ? null : $content;
    }
}
