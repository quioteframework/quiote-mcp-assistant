<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Tools;

use QuioteMcpAssistant\Mcp\Recipes\RecipeBook;

/**
 * `get_recipe` -- step-by-step instructions + runnable code for a concrete
 * task. Unlike the `new-module`/`add-action`/… prompts (templates the agent
 * expands), this returns the recipe as data the agent can quote directly.
 */
final class GetRecipeTool
{
    /**
     * @return array{task: string, title?: string, steps?: list<array{description: string, code?: string}>, error?: string, available_tasks?: list<string>}
     */
    public function get(string $task): array
    {
        $recipe = RecipeBook::get($task);
        if ($recipe === null) {
            return [
                'task' => $task,
                'error' => sprintf('No recipe for "%s".', $task),
                'available_tasks' => RecipeBook::tasks(),
            ];
        }

        return [
            'task' => strtolower(trim($task)),
            'title' => $recipe['title'],
            'steps' => $recipe['steps'],
        ];
    }
}
