<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Recipes;

/**
 * Hand-authored recipes: step-by-step instructions + runnable code for a
 * concrete task, one level more code-heavy and less conceptual than a
 * {@see \QuioteMcpAssistant\Mcp\Conventions\ConventionCards}
 * card. Returned directly by the `get_recipe` tool as structured data (not a
 * prompt template) so an agent can quote the code verbatim.
 */
final class RecipeBook
{
    /** @return list<string> */
    public static function tasks(): array
    {
        return array_keys(self::recipes());
    }

    /** @return array{title: string, steps: list<array{description: string, code?: string}>}|null */
    public static function get(string $task): ?array
    {
        return self::recipes()[strtolower(trim($task))] ?? null;
    }

    /** @return array<string, array{title: string, steps: list<array{description: string, code?: string}>}> */
    private static function recipes(): array
    {
        return [
            'new-project' => [
                'title' => 'Scaffold a brand-new Quiote application',
                'steps' => [
                    ['description' => 'Quiote is not yet on Packagist -- install it from GitHub directly into the (empty or nonexistent) directory you want the app in. This creates that directory\'s own composer.json + vendor/, which the scaffolded app\'s front controller will locate at runtime. minimum-stability/prefer-stable are required, not optional -- a plain "composer require quioteframework/quiote:dev-main" fails: quiote\'s dev-main branch depends on quioteframework/csrf\'s dev-main branch too, which composer\'s default "stable" minimum-stability rejects.', 'code' => <<<'BASH'
                        mkdir my-app && cd my-app
                        composer init --no-interaction --name you/my-app
                        composer config minimum-stability dev
                        composer config prefer-stable true
                        composer require quioteframework/quiote:dev-main --no-interaction
                        BASH],
                    ['description' => 'Run `quiote new` to scaffold the application files -- a Default module (Index/About/Boom actions), the minimal Config/ needed to boot, and a FrankenPHP-ready pub/index.php. Target "." since composer already populated this directory (composer.json/vendor/ make it non-empty, hence --force); --namespace defaults to "App", --config-format defaults to "php" (also accepts yaml/xml).', 'code' => <<<'BASH'
                        vendor/bin/quiote new . --force
                        # or, e.g.: vendor/bin/quiote new . --force --namespace Shop --config-format yaml
                        BASH],
                    ['description' => 'Smoke test it -- GET /, /about, and /boom (the last deliberately throws, to see error handling) should all respond.', 'code' => <<<'BASH'
                        php -S localhost:8000 -t pub pub/index.php
                        # or, with FrankenPHP:
                        frankenphp php-server --root pub
                        BASH],
                    ['description' => 'From here, use project_info/list_routes (once this MCP server is relaunched with --target-app-dir pointed at the new app) to confirm what was generated, and scaffold_module/scaffold_action/scaffold_plugin/scaffold_db_connection to keep building -- rather than hand-writing files that already have a generator.'],
                ],
            ],
            'read-only-action' => [
                'title' => 'Add a read-only (GET) action',
                'steps' => [
                    ['description' => 'Create the action class in the module\'s Actions/ directory.', 'code' => <<<'PHP'
                        <?php
                        namespace App\Modules\Blog\Actions;

                        use Quiote\Action\Action;
                        use Quiote\Request\WebRequest;

                        class PostAction extends Action
                        {
                            public function executeRead(WebRequest $rd)
                            {
                                $slug = $rd->getParameter('slug');
                                $this->setAttribute('slug', $slug);
                                return 'Success';
                            }

                            public function getDefaultViewName(): string
                            {
                                return 'Success';
                            }
                        }
                        PHP],
                    ['description' => 'Declare a validator for the "slug" path parameter (an action can only read validator-approved parameters) -- either override registerValidators() or drop a file in Modules/Blog/Validate/.', 'code' => <<<'PHP'
                        <?php
                        use Quiote\Validator\Compiler\Runtime\ValidatorBuilder;

                        return static function (ValidatorBuilder $v): void {
                            $v->string('slug', required: true)->minLength(1);
                        };
                        PHP],
                    ['description' => 'Register a route pointing at Blog.Post, e.g. in the app\'s Routing subclass.', 'code' => <<<'PHP'
                        $routes->add('post', new Route('/blog/{slug}', ['_module' => 'Blog', '_action' => 'Post']));
                        $meta['post'] = ['gen_path' => '/blog/{slug}', 'path' => '/blog/{slug}', 'cut' => false];
                        PHP],
                    ['description' => 'Add the view + template for the "Success" view name returned above (Views/PostSuccessView.php, Templates/PostSuccess.php).'],
                ],
            ],
            'multi-output-view' => [
                'title' => 'Serve HTML and JSON (or another format) from one view',
                'steps' => [
                    ['description' => 'One view, one execute<OutputType>() method per format it should serve. The action does not change -- the same executeRead() sets the same attributes; only the view method that consumes them differs by output type.', 'code' => <<<'PHP'
                        <?php
                        namespace App\Modules\Blog\Views;

                        use Quiote\Request\WebRequest;
                        use Quiote\View\View;

                        class PostSuccessView extends View
                        {
                            public function executeHtml(WebRequest $rd): void
                            {
                                $this->loadLayout();
                                $this->setAttribute('title', 'Post');
                                // returns nothing -> the loaded template layers render
                            }

                            public function executeJson(WebRequest $rd): string
                            {
                                return json_encode(['title' => $this->getAttribute('title')], JSON_THROW_ON_ERROR);
                                // returns a string -> that string is the response body, no template needed
                            }
                        }
                        PHP],
                    ['description' => 'HTML needs a template (Templates/PostSuccess.php); JSON/XML/etc. generally don\'t -- they build and return the body string directly. Only add a template file for formats that actually render one.'],
                    ['description' => 'Every output type the view serves must be declared in Config/output_types.xml -- html ships by default in a fresh app, others (like json) usually need adding. A JSON-like type needs no <layouts> at all.', 'code' => <<<'XML'
                        <!-- Config/output_types.xml -- inside <output_types> -->
                        <output_type name="json">
                            <renderers default="php">
                                <renderer name="php" class="Quiote\Renderer\PhpRenderer" />
                            </renderers>
                            <parameter name="http_headers">
                                <parameter name="Content-Type">application/json; charset=UTF-8</parameter>
                            </parameter>
                        </output_type>
                        XML],
                    ['description' => 'scaffold_action(module, action, formats: ["html", "json"]) generates all of the above in one call -- the view\'s execute<Format>() methods, the html template, and (if Config/output_types.xml doesn\'t already declare a requested format) a ready-to-paste snippet for it.'],
                ],
            ],
            'form-action' => [
                'title' => 'Add a form action (GET to display, POST to submit)',
                'steps' => [
                    ['description' => 'Implement both executeRead (display the form) and executeWrite (handle the submission) on one action.', 'code' => <<<'PHP'
                        <?php
                        namespace App\Modules\Contact\Actions;

                        use Quiote\Action\Action;
                        use Quiote\Request\WebRequest;

                        class SendAction extends Action
                        {
                            public function executeRead(WebRequest $rd)
                            {
                                return 'Input';
                            }

                            public function executeWrite(WebRequest $rd)
                            {
                                // $rd->getParameter('email') / ->getParameter('message') are
                                // available here because the validators below approved them.
                                return 'Success';
                            }

                            public function getDefaultViewName(): string
                            {
                                return 'Input';
                            }
                        }
                        PHP],
                    ['description' => 'Declare validators for the POST verb only with registerWriteValidators() (it runs only for POST) -- GET requests to display the empty form need none.', 'code' => <<<'PHP'
                        use Quiote\Validator\Compiler\Runtime\ValidatorBuilder;

                        public function registerWriteValidators(ValidatorBuilder $v): void
                        {
                            $v->string('email', required: true);
                            $v->email('email', required: true);
                            $v->string('message', required: true)->minLength(1)->maxLength(2000);
                        }
                        PHP],
                    ['description' => 'Add both view names\' views/templates: Input (the empty form) and Success (after submission). handleError() decides which view a validation failure falls back to (defaults to "Error").'],
                ],
            ],
            'add-plugin' => [
                'title' => 'Write and register a plugin',
                'steps' => [
                    ['description' => 'Implement PluginInterface -- just a register() that only calls PluginRegistrar methods; the interface declares no name() method. #[Plugin(name: ...)] is required, not optional: a class named via a class-string activation source (plugins.* or PluginManager::add() passed a string) is silently refused -- logged, not thrown -- unless it carries this attribute as a deliberate opt-in, and its name argument is also what PluginManager reads for diagnostics/logging (don\'t also add your own name() method -- nothing calls it). Only implement NamedPlugin instead of passing name to the attribute if the name genuinely can\'t be a compile-time constant (computed from config, an env value, etc).', 'code' => <<<'PHP'
                        <?php
                        namespace App\Plugin;

                        use Quiote\DI\Container;
                        use Quiote\Plugin\Attribute\Plugin;
                        use Quiote\Plugin\{PluginInterface, PluginRegistrar};

                        #[Plugin(name: 'health')]
                        final class HealthPlugin implements PluginInterface
                        {
                            public function register(PluginRegistrar $r): void
                            {
                                $r->configDefault('health.path', '/healthz')
                                  ->service(HealthChecker::class, HealthChecker::class, Container::SCOPE_SINGLETON)
                                  ->command(\App\Plugin\Health\HealthCommand::class);
                            }
                        }
                        PHP],
                    ['description' => 'Activate it via Config/plugins.php -- the canonical, auto-discovered file for this (Quiote::bootstrap() looks for %core.config_dir%/plugins.{php,yaml,yml,xml} directly, PHP taking priority if more than one exists). This is NOT a "plugins" key inside settings.php -- writing one there happens to still work (it shares the same underlying config key) but is an unsupported, undocumented incidental side effect, not the interface to target. Each entry is {class, enabled?} (enabled defaults to true), not a bare class-string -- create the file fresh if this app has no plugins yet.', 'code' => <<<'PHP'
                        <?php
                        // Config/plugins.php
                        return [
                            ['class' => \App\Plugin\HealthPlugin::class],
                            // ['class' => \App\Plugin\SomeOtherPlugin::class, 'enabled' => false],
                        ];
                        PHP],
                    ['description' => 'Config/plugins.xml (or .yaml/.yml) is the same mechanism in that format -- see quiote-docs://architecture/plugins for the exact XML/YAML shape. A module can also ship its own %core.module_dir%/<Module>/Config/plugins.xml, contributing without any change to the app-level file.'],
                ],
            ],
            'add-database-connection' => [
                'title' => 'Add a database connection',
                'steps' => [
                    ['description' => 'Set core.use_database = true in Config/settings.php.'],
                    ['description' => 'Declare the connection in Config/databases.xml, naming a driver (pdo, or an ORM adapter alias like eloquent/doctrine_orm/doctrine_dbal/cycle/propulsion if that plugin is enabled).'],
                    ['description' => 'Get the lifecycle wrapper via the context, then the real connection/ORM object from it.', 'code' => <<<'PHP'
                        $db   = $context->getDatabaseManager()->getDatabase('main'); // Quiote\Database\Database
                        $conn = $db->getConnection(); // PDO, or the adapter's ORM object
                        PHP],
                ],
            ],
            'throttle-login' => [
                'title' => 'Rate-limit repeated login attempts',
                'steps' => [
                    ['description' => 'Install quioteframework/ratelimit -- a plain library, not a plugin (no "plugins" entry). It provides LoginThrottle (sliding-window counter per key, e.g. IP or username) and PdoRateLimiterStorage (state kept in your own database, no Redis needed).', 'code' => <<<'BASH'
                        composer require quioteframework/ratelimit
                        BASH],
                    ['description' => 'Create the storage table once (PdoRateLimiterStorage::schema() returns Postgres/SQLite-compatible DDL) -- e.g. from a one-off console command or migration, using the same PDO connection the app already has via the DatabaseManager.', 'code' => <<<'PHP'
                        <?php
                        $conn = $context->getDatabaseManager()->getDatabase('main')->getConnection(); // PDO
                        $conn->exec(\Quiote\Security\RateLimit\PdoRateLimiterStorage::schema());
                        PHP],
                    ['description' => 'Wire it into the login action: peek with retryAfter() before doing any real auth work (cheap rejection of a flood), registerFailure() on a bad password, reset() on success so a legitimate user is never penalized for an earlier typo. Build LoginThrottle lazily inside execute*(), not the constructor -- getContext() (needed to reach the DatabaseManager) returns null until the executor calls initialize() on the action, which happens after the constructor runs. maxAttempts/interval are constructor args -- this example is 5 attempts per 60 seconds; the constructor defaults to 10 per 15 minutes if omitted. Do NOT add isSimple(): true here, even though other scaffolded actions have it -- isSimple() skips execute*() entirely and always renders getDefaultViewName() directly, which only looks harmless on an action whose default view happens to match its execute*() return value. This action must return a different view per outcome (Throttled/Error/Success), so isSimple() must stay at its default (false) or the throttle/auth logic below silently never runs.', 'code' => <<<'PHP'
                        <?php
                        namespace App\Modules\Auth\Actions;

                        use Quiote\Action\Action;
                        use Quiote\Request\WebRequest;
                        use Quiote\Security\RateLimit\LoginThrottle;
                        use Quiote\Security\RateLimit\PdoRateLimiterStorage;

                        class LoginAction extends Action
                        {
                            public function executeWrite(WebRequest $rd)
                            {
                                $throttle = $this->throttle();

                                // Keying by IP throttles a single source regardless of which
                                // username it tries; key by the submitted username instead (or
                                // both, checked separately) to stop credential stuffing across IPs.
                                $key = $rd->getServerParams()['REMOTE_ADDR'] ?? 'unknown';

                                if (($wait = $throttle->retryAfter($key)) !== null) {
                                    $this->setAttribute('retryAfter', $wait);
                                    return 'Throttled';
                                }

                                if (!$this->credentialsAreValid($rd)) {
                                    if (($wait = $throttle->registerFailure($key)) !== null) {
                                        $this->setAttribute('retryAfter', $wait);
                                        return 'Throttled';
                                    }
                                    return 'Error';
                                }

                                $throttle->reset($key);
                                return 'Success';
                            }

                            public function getDefaultViewName(): string
                            {
                                return 'Input';
                            }

                            private function throttle(): LoginThrottle
                            {
                                $conn = $this->getContext()->getDatabaseManager()->getDatabase('main')->getConnection();
                                return new LoginThrottle(new PdoRateLimiterStorage($conn), maxAttempts: 5, interval: '60 seconds', id: 'login');
                            }
                        }
                        PHP],
                    ['description' => 'Add the "Throttled" view/template alongside the action\'s existing Input/Success/Error ones -- render a 429-style "too many attempts, try again in N seconds" message using the retryAfter attribute set above.'],
                ],
            ],
            'expose-action-as-tool' => [
                'title' => 'Expose an existing #[Route] action as an MCP tool',
                'steps' => [
                    ['description' => 'Add #[McpTool] to the action class alongside its existing #[Route] attribute.', 'code' => <<<'PHP'
                        use Mcp\Capability\Attribute\McpTool;
                        use Quiote\Routing\Attribute\Route;

                        #[Route(path: '/blog/{slug}', name: 'blog.post')]
                        #[McpTool(name: 'get_blog_post')]
                        class PostAction extends Action { /* ... */ }
                        PHP],
                    ['description' => 'Set mcp.expose_actions = true and mcp.enabled = true, and add Quiote\Mcp\McpPlugin to the plugins key.', 'code' => <<<'PHP'
                        'plugins' => [\Quiote\Mcp\McpPlugin::class],
                        'mcp.enabled' => true,
                        'mcp.expose_actions' => true,
                        PHP],
                    ['description' => 'The action\'s DI, verb dispatch, and validators are reused as-is via the same request pipeline a real HTTP call would go through. The tool\'s inputSchema is derived automatically from the action\'s validators (scoped to the verb the route dispatches to) -- string minLength/maxLength, number min/max, email format, enum values, regex pattern, and so on -- so one validator declaration drives both HTTP validation and the advertised schema. A field only falls back to a looser/no schema entry when its rule genuinely can\'t map to JSON Schema (e.g. a negative regex); validation still runs for real on dispatch either way, and additionalProperties stays true.'],
                ],
            ],
            'register-mcp-tool' => [
                'title' => 'Register a plain (non-action) MCP tool',
                'steps' => [
                    ['description' => 'Write a plain, autowireable class with a method taking typed parameters and returning a string or array -- no attribute needed (there is no attribute discovery for plain classes).', 'code' => <<<'PHP'
                        <?php
                        namespace App\Mcp\Tools;

                        final class GreetTool
                        {
                            public function greet(string $name): string
                            {
                                return "Hello, {$name}!";
                            }
                        }
                        PHP],
                    ['description' => 'Register it manually in a plugin\'s register(), including an explicit JSON Schema for the input.', 'code' => <<<'PHP'
                        $registrar->mcpTool(
                            handlerFqcn: \App\Mcp\Tools\GreetTool::class,
                            method: 'greet',
                            name: 'greet',
                            description: 'Greet someone by name.',
                            inputSchema: [
                                'type' => 'object',
                                'properties' => ['name' => ['type' => 'string']],
                                'required' => ['name'],
                            ],
                        );
                        PHP],
                    ['description' => 'Ensure the plugin is in the plugins config key and mcp.enabled = true, then run mcp:serve.'],
                ],
            ],
        ];
    }
}
