<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Prompts;

use QuioteMcpAssistant\Mcp\Conventions\ConventionCards;

/**
 * Reusable, parameterized prompt templates. Each method
 * stitches the relevant convention card(s) + a concrete recipe into a single
 * user message so an MCP client can drop it in and have the agent emit
 * idiomatic Quiote code for the requested task.
 *
 * Prompt argument names/requiredness are derived by the SDK from these methods'
 * reflection, so the parameter names below become the prompt's advertised
 * arguments. Each returns the SDK's array-of-messages shape.
 */
final class ScaffoldPrompts
{
    /** @return list<array{role: string, content: string}> */
    public function newModule(string $module = 'Blog'): array
    {
        return $this->user(<<<MD
            Add a new module named "{$module}" to this Quiote app, following its conventions.

            A module is a directory under the app's `Modules/` (namespace
            `<AppNamespace>\\Modules\\{$module}`) holding `Actions/`, `Views/`, `Templates/`,
            and optionally `Validate/`. Do this:

            1. Create `Modules/{$module}/Actions/IndexAction.php` with an `IndexAction` extending
               `Quiote\\Action\\Action`, an `executeRead(WebRequest \$rd)` returning `'Success'`,
               and `getDefaultViewName()` returning `'Success'`. If it has no validators, also
               `return true` from `isSimple()`.
            2. Add a matching view + template (see the add-action guidance for the view contract).
            3. Register at least one route pointing at the module — either in the Routing subclass
               (`_module => '{$module}'`) or via a `#[Route]` attribute on the action.

            {$this->cards('actions', 'routing', 'config')}
            MD);
    }

    /** @return list<array{role: string, content: string}> */
    public function addAction(string $module = 'Blog', string $name = 'Post', string $verbs = 'read'): array
    {
        return $this->user(<<<MD
            Add an action "{$name}" to module "{$module}" handling the verb(s): {$verbs}.

            1. Create `Modules/{$module}/Actions/{$name}Action.php` — class `{$name}Action extends
               Quiote\\Action\\Action`. For each requested verb, implement the mapped method
               (read→`executeRead`, write→`executeWrite`, update→`executeUpdate`,
               remove→`executeRemove`), each taking a `Quiote\\Request\\WebRequest` and returning a
               **view name** string (e.g. `'Success'`). Pass data to the view via
               `\$this->setAttribute(...)`.
            2. If the action reads any input, declare validators (see the card below) via
               `registerValidators()` or a `Modules/{$module}/Validate/` file — an action can only
               read validator-approved parameters. Otherwise `return true` from `isSimple()`.
            3. Add a `Views/{$name}<ViewName>View.php` and `Templates/{$name}<ViewName>.php` for the
               returned view name, and register a route to `{$module}.{$name}`.

            {$this->cards('actions', 'validation')}
            MD);
    }

    /** @return list<array{role: string, content: string}> */
    public function addService(string $name = 'OrderService', string $scope = 'transient'): array
    {
        return $this->user(<<<MD
            Add a DI-resolved service "{$name}" (scope: {$scope}) to this Quiote app.

            1. Write the class with its collaborators as **constructor parameters** (the container
               autowires them by type). Keep it stateless unless you deliberately choose singleton
               scope — workers are long-lived.
            2. Register it where appropriate: in a plugin's `register()` via
               `\$r->service({$name}::class, {$name}::class, Container::SCOPE_{$this->scopeConst($scope)})`,
               or directly on a container with `set()`/`setFactory()`/`alias()`.
            3. Consume it by declaring it as a constructor parameter of an action/other service, or
               resolve it explicitly with `\$container->get({$name}::class)`.

            {$this->cards('di', 'plugins')}
            MD);
    }

    /** @return list<array{role: string, content: string}> */
    public function addPlugin(string $name = 'HealthPlugin'): array
    {
        return $this->user(<<<MD
            Write a Quiote plugin "{$name}".

            1. Implement `Quiote\\Plugin\\PluginInterface`: a `name()` returning a stable string,
               and `register(PluginRegistrar \$r)` (called once at boot).
            2. In `register()`, contribute through the fluent `PluginRegistrar` seams only
               (`configDefault`, `service`, `middleware`/`attributedMiddleware`, `listen`,
               `moduleDirectory`, `command`, `httpClient`, `databaseDriver`, `mcp*`). Config
               defaults and services are set-if-absent, so keep them safe.
            3. Enable it by adding `{$name}::class` to the `plugins` config key in
               `Config/settings.php`.

            {$this->cards('plugins', 'di')}
            MD);
    }

    /** @return list<array{role: string, content: string}> */
    public function addDbConnection(string $name = 'main', string $driver = 'pdo'): array
    {
        return $this->user(<<<MD
            Add a database connection named "{$name}" using the "{$driver}" adapter.

            1. Set `core.use_database = true` in `Config/settings.php`.
            2. Declare the connection in `Config/databases.xml`, naming the "{$driver}" driver
               alias and its DSN/credentials. For an ORM adapter (eloquent, doctrine_orm,
               doctrine_dbal, cycle, propulsion), ensure that ORM's plugin is enabled.
            3. Use it: `\$db = \$context->getDatabaseManager()->getDatabase('{$name}');` then
               `\$conn = \$db->getConnection();` (returns PDO or the ORM object). The `Database`
               wrapper handles lifecycle across worker requests.

            {$this->cards('database', 'config')}
            MD);
    }

    /** @return list<array{role: string, content: string}> */
    public function exposeMcpTool(string $action = 'Blog.Post'): array
    {
        return $this->user(<<<MD
            Expose the existing `#[Route]` action "{$action}" as an MCP tool.

            1. Add the `#[Mcp\\Capability\\Attribute\\McpTool]` attribute (from the framework's MCP
               integration) to the action class that already carries `#[Route]`.
            2. Set `mcp.expose_actions = true` and `mcp.enabled = true` in settings, and add
               `Quiote\\Mcp\\McpPlugin` to the `plugins` key.
            3. The action's DI, verb dispatch, and validators are reused automatically; the tool's
               `inputSchema` is derived from those validators (scoped to the verb the route
               dispatches to), falling back to a looser shape only where a rule can't map to JSON
               Schema -- validation still runs for real on dispatch either way. For a *plain*
               (non-action) tool instead, register it manually via `PluginRegistrar::mcpTool()`.

            {$this->cards('mcp', 'actions')}
            MD);
    }

    /**
     * Assemble the referenced convention cards into a single Markdown block.
     */
    private function cards(string ...$topics): string
    {
        $out = "---\nRelevant Quiote conventions:\n";
        foreach ($topics as $topic) {
            $card = ConventionCards::get($topic);
            if ($card !== null) {
                $out .= "\n## {$card['title']}\n\n{$card['body']}\n";
            }
        }

        return $out;
    }

    private function scopeConst(string $scope): string
    {
        return match (strtolower($scope)) {
            'singleton' => 'SINGLETON',
            'request' => 'REQUEST',
            default => 'TRANSIENT',
        };
    }

    /** @return list<array{role: string, content: string}> */
    private function user(string $content): array
    {
        return [['role' => 'user', 'content' => $content]];
    }
}
