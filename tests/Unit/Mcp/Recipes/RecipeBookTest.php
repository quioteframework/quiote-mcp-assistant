<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Unit\Mcp\Recipes;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use QuioteMcpAssistant\Mcp\Recipes\RecipeBook;

/**
 * get_recipe hands its code samples straight to an agent as "runnable
 * code" -- a syntax error in one would be quoted verbatim into someone's
 * project. Every PHP-looking sample is linted for real via php -l rather
 * than just checked for non-emptiness.
 */
final class RecipeBookTest extends TestCase
{
    #[Test]
    public function everyAdvertisedTaskResolvesToACompleteRecipe(): void
    {
        $tasks = RecipeBook::tasks();
        self::assertNotEmpty($tasks);

        foreach ($tasks as $task) {
            $recipe = RecipeBook::get($task);
            self::assertNotNull($recipe, "Task \"{$task}\" is listed but get() returned null.");
            self::assertNotSame('', $recipe['title'], "Task \"{$task}\" has an empty title.");
            self::assertNotEmpty($recipe['steps'], "Task \"{$task}\" has no steps.");

            foreach ($recipe['steps'] as $i => $step) {
                self::assertNotSame('', $step['description'], "Task \"{$task}\" step {$i} has an empty description.");
            }
        }
    }

    #[Test]
    public function everyPhpCodeSampleIsSyntacticallyValid(): void
    {
        foreach (RecipeBook::tasks() as $task) {
            $recipe = RecipeBook::get($task);
            self::assertNotNull($recipe);

            foreach ($recipe['steps'] as $i => $step) {
                $code = $step['code'] ?? null;
                if ($code === null || !str_starts_with(ltrim($code), '<?php')) {
                    continue;
                }
                self::assertValidPhp($code, "Task \"{$task}\" step {$i}'s code sample");
            }
        }
    }

    #[Test]
    public function getIsCaseInsensitiveAndTrimsWhitespace(): void
    {
        $recipe = RecipeBook::get('  Add-Plugin  ');

        self::assertNotNull($recipe);
        self::assertSame(RecipeBook::get('add-plugin'), $recipe);
    }

    #[Test]
    public function getReturnsNullForAnUnknownTask(): void
    {
        self::assertNull(RecipeBook::get('nonexistent-task'));
    }

    private static function assertValidPhp(string $content, string $label): void
    {
        $tmpFile = tempnam(sys_get_temp_dir(), 'recipe-code-test-');
        self::assertIsString($tmpFile);
        file_put_contents($tmpFile, $content);

        exec('php -l ' . escapeshellarg($tmpFile) . ' 2>&1', $output, $exitCode);
        unlink($tmpFile);

        self::assertSame(0, $exitCode, "{$label} is not valid PHP:\n" . implode("\n", $output) . "\n\n---\n{$content}");
    }
}
