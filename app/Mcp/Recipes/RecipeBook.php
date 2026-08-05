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
                    ['description' => 'Install Quiote from Packagist into the (empty or nonexistent) directory you want the app in. This creates that directory\'s own composer.json + vendor/, which the scaffolded app\'s front controller locates at runtime. Tagged stable releases are published (3.x at time of writing), so no minimum-stability/prefer-stable configuration is needed -- a plain require resolves ^3.0 under composer\'s default "stable" setting. Only add `composer config minimum-stability dev` + `prefer-stable true` if you deliberately want to track the unreleased dev-main branch.', 'code' => <<<'BASH'
                        mkdir my-app && cd my-app
                        composer init --no-interaction --name you/my-app
                        composer require quioteframework/quiote --no-interaction
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
                    ['description' => 'Activate Quiote\Mcp\McpPlugin in Config/plugins.php -- entries are {class, enabled?}, NOT a bare class-string, and NOT a "plugins" key inside settings.php.', 'code' => <<<'PHP'
                        <?php
                        // Config/plugins.php
                        return [
                            ['class' => \Quiote\Mcp\McpPlugin::class],
                        ];
                        PHP],
                    ['description' => 'Set the two mcp.* settings in Config/settings.php. expose_actions is what turns #[McpTool]-annotated actions into tools; without mcp.enabled the plugin registers nothing.', 'code' => <<<'PHP'
                        <?php
                        // Config/settings.php -- inside the returned array
                        return [
                            'mcp.enabled' => true,
                            'mcp.expose_actions' => true,
                        ];
                        PHP],
                    ['description' => 'The action\'s DI, verb dispatch, and validators are reused as-is via the same request pipeline a real HTTP call would go through -- Quiote\Mcp\Bridge\ActionToolAdapter drives a synthetic request through Context::handle() (not ActionExecutor::execute() directly), so a tool call gets the exact same DI resolution, verb dispatch, and validation a real HTTP request would. The tool\'s inputSchema is derived automatically from the action\'s validators (scoped to the verb the route dispatches to) -- string minLength/maxLength, number min/max, email format, enum values, regex pattern, and so on -- so one validator declaration drives both HTTP validation and the advertised schema. A field only falls back to a looser/no schema entry when its rule genuinely can\'t map to JSON Schema (e.g. a negative regex); validation still runs for real on dispatch either way, and additionalProperties stays true.'],
                    ['description' => 'A forwarded request fails the tool call rather than silently succeeding. Status alone can\'t distinguish success from failure here -- a security forward renders the login/secure action and still returns HTTP 200, so without this a tool call against a protected action would report success and hand the connected model the login page\'s markup as though it were the action\'s real output. The adapter attaches its own ExecutionState to the synthetic request and raises a ToolCallException (surfacing as isError: true, naming the action actually reached) if the request was forwarded -- any forward fails the call, not only a security one.'],
                    ['description' => 'The HTTP transport\'s own auth (mcp.auth: bearer/oauth2/none) is a separate concern from this recipe -- see the "secure-mcp-endpoint" recipe for wiring OAuth2 resource-server auth onto the endpoint itself.'],
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
                    ['description' => 'Register it manually from a plugin\'s register(), including an explicit JSON Schema for the input. Register against Quiote\Mcp\McpCatalog (a static registry from the separate quioteframework/mcp package) -- NOT via $registrar: PluginRegistrar has no mcpTool()/mcpResource()/mcpPrompt() method. Those convenience wrappers used to exist on core\'s PluginRegistrar and forwarded here, but the quioteframework/mcp monorepo split removed them (core can no longer depend on the now-optional MCP package) without adding replacements, so calling them is a fatal error.', 'code' => <<<'PHP'
                        <?php
                        use Quiote\Mcp\McpCatalog;

                        // Inside your plugin's register(PluginRegistrar $registrar): void
                        McpCatalog::addTool(
                            // The handler is ONE [class-string, method] pair -- not separate
                            // handlerFqcn/method arguments. A \Closure or a plain
                            // class-string (with an __invoke method) also works.
                            [\App\Mcp\Tools\GreetTool::class, 'greet'],
                            name: 'greet',
                            description: 'Greet someone by name.',
                            inputSchema: [
                                'type' => 'object',
                                'properties' => ['name' => ['type' => 'string']],
                                'required' => ['name'],
                            ],
                        );
                        PHP],
                    ['description' => 'The full signatures -- note $title sits between $name and $description, so pass the rest as named arguments rather than positionally: McpCatalog::addTool($handler, ?$name, ?$title, ?$description, ?$inputSchema, ?$outputSchema); addResource($handler, $uri, ?$name, ?$title, ?$description, ?$mimeType); addPrompt($handler, ?$name, ?$title, ?$description). Handlers resolve through the DI container, and the handler method\'s parameters map from the call arguments by name (a resource handler also receives `uri`). A tool handler returns a string or array, a resource handler a string, and a prompt handler a list of [\'role\' => ..., \'content\' => ...] messages.'],
                    ['description' => 'Activate the plugin in Config/plugins.php and set mcp.enabled = true in Config/settings.php, then run `vendor/bin/quiote mcp:serve`.'],
                ],
            ],
            'background-job' => [
                'title' => 'Run work in the background with a queued job',
                'steps' => [
                    ['description' => 'Install quioteframework/queue. On its own it is already a working queue -- but the default "sync" driver runs jobs INLINE in the request that pushed them, with blocking retries. Add quioteframework/queue-db (or queue-redis) for a real backlog that a separate worker drains; that is what you want in production. `vendor/bin/quiote make:job SendWelcomeEmail --retryable` scaffolds the class below.', 'code' => <<<'BASH'
                        composer require quioteframework/queue
                        composer require quioteframework/queue-db   # persistent backlog
                        BASH],
                    ['description' => 'Write the job: implement Quiote\Queue\Job -- a single handle(): void. The job is constructed fresh per attempt via Container::make(), so constructor-injected SERVICES autowire normally and only the job\'s own data needs to travel through the queue as params. Implement RetryableJob instead (it extends Job) to set the retry policy per job; otherwise the queue.retry.* config defaults apply (3 attempts, 5s backoff).', 'code' => <<<'PHP'
                        <?php
                        namespace App\Job;

                        use Quiote\Queue\RetryableJob;

                        final class SendWelcomeEmail implements RetryableJob
                        {
                            // $mailer autowires; $userId travels in the payload.
                            public function __construct(
                                private readonly \App\Service\Mailer $mailer,
                                private readonly int $userId,
                            ) {}

                            public function handle(): void
                            {
                                $this->mailer->sendWelcome($this->userId);
                            }

                            public function maxAttempts(): int
                            {
                                return 5; // total attempts, including the first
                            }

                            public function backoffSeconds(int $attempt): int
                            {
                                return $attempt * 10;
                            }
                        }
                        PHP],
                    ['description' => 'Push it. With a persistent driver the params must be JSON-serializable, and delaySeconds is only meaningful there (the sync driver has nothing to defer to).', 'code' => <<<'PHP'
                        $queue = $this->getContext()->getContainer()->get(\Quiote\Queue\QueueManager::class);

                        $queue->push(\App\Job\SendWelcomeEmail::class, ['userId' => 5]);
                        $queue->push(\App\Job\SendWelcomeEmail::class, ['userId' => 5], delaySeconds: 300);
                        PHP],
                    ['description' => 'Activate the plugins and point the default driver at db. Both queue-db tables must be created by hand -- nothing creates them at runtime -- from the portable DDL that DbQueueDriver::schema() and DbFailedJobStore::schema() return. The connection named by queue.db.connection must be PDO-backed.', 'code' => <<<'PHP'
                        <?php
                        // Config/plugins.php
                        return [
                            ['class' => \Quiote\Queue\QueuePlugin::class],
                            ['class' => \Quiote\Queue\Db\QueueDbPlugin::class],
                        ];
                        PHP],
                    ['description' => 'Drain the backlog with a long-running worker process. Running queue:work against the sync driver fails fast with a clear error rather than spinning uselessly.', 'code' => <<<'BASH'
                        php bin/quiote queue:work --driver=db
                        # --max-jobs=N, --sleep=N, --stop-when-empty
                        BASH],
                    ['description' => 'quioteframework/queue-redis is the other persistent driver, and needs no schema/migration step (unlike queue-db). Its connection is self-contained -- built straight from a DSN, not the app\'s DatabaseManager -- and it is a real reliable queue, not a bare list pop: ready jobs sit in a Redis LIST ({prefix}:ready), reserve() atomically RPOPLPUSHes one into a {prefix}:processing LIST so a crashed worker leaves the job recoverable rather than lost, and delayed/released jobs live in a {prefix}:delayed ZSET scored by due timestamp.', 'code' => <<<'BASH'
                        composer require quioteframework/queue-redis predis/predis
                        BASH],
                    ['description' => 'Activate QueueRedisPlugin instead of (or alongside) QueueDbPlugin and point queue.default_driver at redis. Only two settings: queue.redis.dsn (default redis://127.0.0.1:6379) and queue.redis.prefix (default quiote_queue).', 'code' => <<<'PHP'
                        <?php
                        // Config/plugins.php
                        return [
                            ['class' => \Quiote\Queue\QueuePlugin::class],
                            ['class' => \Quiote\Queue\Redis\QueueRedisPlugin::class],
                        ];
                        // Config/settings.php
                        return ['queue.default_driver' => 'redis'];
                        PHP],
                    ['description' => 'Optional but recommended: bind DbFailedJobStore so exhausted jobs land in a queryable dead-letter table. queue-db registers the class but deliberately does NOT make it the default -- without this you keep LogFailedJobStore, which only logs the failure and drops it, and the queue:failed:list/retry/forget commands will refuse to run. Do this in a plugin\'s register().', 'code' => <<<'PHP'
                        $registrar->service(
                            \Quiote\Queue\FailedJobStoreInterface::class,
                            static fn($container) => $container->get(\Quiote\Queue\Db\DbFailedJobStore::class),
                        );
                        PHP],
                ],
            ],
            'scheduled-task' => [
                'title' => 'Run a task on a cron schedule',
                'steps' => [
                    ['description' => 'Install quioteframework/scheduler. It layers on quioteframework/queue -- the recommended shape for a scheduled task is "dispatch a job", so the work runs through the queue driver you already configured, with its retry and dead-letter handling.', 'code' => <<<'BASH'
                        composer require quioteframework/scheduler
                        BASH],
                    ['description' => 'Declare what runs and when in one Schedule subclass. define() is re-read on every schedule:run, so definitions always come fresh from code -- adding or moving a task is a code change, never a crontab change. A task with NO cron call at all defaults to every minute.', 'code' => <<<'PHP'
                        <?php
                        namespace App\Schedule;

                        use App\Job\RebuildSearchIndex;
                        use App\Job\SendDigestEmails;
                        use App\Service\SessionReaper;
                        use Quiote\DI\Container;
                        use Quiote\Scheduler\Schedule;

                        final class AppSchedule extends Schedule
                        {
                            protected function define(): void
                            {
                                // ->job() dispatches onto QueueManager and returns immediately.
                                $this->job(SendDigestEmails::class)->dailyAt('06:00');
                                $this->job(RebuildSearchIndex::class, ['full' => false])->cron('*/15 * * * *');

                                // ->call() runs in-process; the closure receives the DI container,
                                // so services resolve at run time rather than at definition time.
                                $this->call(fn(Container $c) => $c->get(SessionReaper::class)->gc())
                                     ->hourly()
                                     ->withoutOverlapping(ttlSeconds: 7200);
                            }
                        }
                        PHP],
                    ['description' => 'Cron specs: ->cron(\'*/5 * * * *\') (full dragonmantank/cron-expression syntax), ->everyMinute(), ->hourly(), ->daily(), ->dailyAt(\'06:30\'). withoutOverlapping() SKIPS a due invocation while the lock is held rather than queueing it, and its ttlSeconds (default 3600) is the failsafe if a process dies without releasing -- set it above the task\'s worst-case runtime. It is built on the PSR-16 cache, which has no atomic add-if-absent, so it is best-effort and NOT a distributed lock: make the task idempotent if it must never run twice.'],
                    ['description' => 'Bind your Schedule from a small app plugin. SchedulerPlugin registers a no-op default Schedule, and plugin service contributions are applied register-if-absent -- so your plugin MUST be declared before SchedulerPlugin or the no-op wins and schedule:run silently reports "Ran 0".', 'code' => <<<'PHP'
                        <?php
                        namespace App\Plugin;

                        use App\Schedule\AppSchedule;
                        use Quiote\Plugin\Attribute\Plugin;
                        use Quiote\Plugin\{PluginInterface, PluginRegistrar};
                        use Quiote\Scheduler\Schedule;

                        #[Plugin(name: 'app-schedule')]
                        final class AppSchedulePlugin implements PluginInterface
                        {
                            public function register(PluginRegistrar $registrar): void
                            {
                                $registrar->service(Schedule::class, static fn() => new AppSchedule());
                            }
                        }
                        PHP],
                    ['description' => 'Order the plugins so yours precedes SchedulerPlugin.', 'code' => <<<'PHP'
                        <?php
                        // Config/plugins.php -- order matters here
                        return [
                            ['class' => \Quiote\Queue\QueuePlugin::class],
                            ['class' => \App\Plugin\AppSchedulePlugin::class],
                            ['class' => \Quiote\Scheduler\SchedulerPlugin::class],
                        ];
                        PHP],
                    ['description' => 'Add ONE crontab line per app, regardless of how many tasks the schedule defines. schedule:run is not a daemon -- it evaluates every task against "now", runs the due ones once, prints a summary and exits (non-zero if any threw; a throwing task is caught and reported so it cannot block the rest).', 'code' => <<<'BASH'
                        * * * * * php /path/to/app/bin/quiote schedule:run --app-dir=/path/to/app >> /dev/null 2>&1
                        BASH],
                ],
            ],
            'session-state' => [
                'title' => 'Read and write session state',
                'steps' => [
                    ['description' => 'Sessions are PSR-7 native as of 3.0 -- no session_start(), no $_SESSION, no save handler. Choose a backend by pointing the "session" factory slot at a factory class. The zero-dependency default is file-backed and is what a scaffolded app ships with.', 'code' => <<<'YAML'
                        # Config/factories.yaml
                        session:
                          class: Quiote\Session\FileSessionFactory
                          params:
                            dir: '%core.app_dir%/cache/sessions'

                        # ...or PDO-backed:
                        # session:
                        #   class: Quiote\Session\PdoSessionFactory
                        #   params:
                        #     database: sessions
                        #     table: session
                        YAML],
                    ['description' => 'Redis/S3/GCS/Azure backends each ship a slot factory in their own package (session-redis, session-s3, session-gcs, session-azure) -- name the factory class and configure it; there is no wiring to write. The cloud ones expect a PSR-18 client bound in the container. Cookie settings live on this same slot: cookie_name, session_cookie_lifetime, session_cookie_secure, session_cookie_httponly, session_cookie_samesite, session_migration_grace_seconds.'],
                    ['description' => 'Read and write through the bag on the context. get() normalizes "missing" to your default, so there is no null-vs-false trap.', 'code' => <<<'PHP'
                        $bag = $this->getContext()->getSessionBag();

                        $cart = $bag->get('cart', []);          // default returned when absent
                        $bag->set('cart', $cart);
                        $bag->has('cart');
                        $bag->remove('cart');

                        $bag->getId();
                        $bag->regenerate(true);                 // on privilege change
                        $bag->destroy();
                        PHP],
                    ['description' => 'Guard incidental writes with exists(). Anonymous requests no longer create a session or emit a cookie, which is what keeps a bot or health check from costing a session row -- so consult exists() before persisting DEFAULT or EMPTY state, or you hand every visitor a session they never asked for. A deliberate write (a login, a saved preference) should NOT consult it.', 'code' => <<<'PHP'
                        // Incidental: only record this if a session already exists.
                        if ($bag->exists()) {
                            $bag->set('lastSeen', time());
                        }

                        // Deliberate: always writes, creating the session if needed.
                        $bag->set('locale', $chosenLocale);
                        PHP],
                    ['description' => 'The slot is OPTIONAL -- omit it entirely and the context answers a NullSessionBag (reads return the default, writes are discarded, exists() is false, getId() is \'\'). That is right for a console command, a queue worker or a stateless API. But beware: CsrfValidationMiddleware treats a request arriving without a session cookie as CSRF-exempt, so with no session slot that exemption fires on EVERY request, while CsrfInjectionMiddleware still adds a _csrf_token field to every form -- it looks protected and is not. Configure a session slot before relying on CSRF protection for any state-changing endpoint.'],
                ],
            ],
            'upgrade-to-3' => [
                'title' => 'Upgrade an app from Quiote 2.x to 3.0',
                'steps' => [
                    ['description' => '3.0 replaces the session subsystem: the ext/session-backed "storage" component is gone. Most apps need three changes -- swap one factory slot, replace getStorage() calls, and accept that everyone is logged out once. Old $_SESSION payloads are NOT migrated and there is no converter, so plan the deploy around a one-time logout.'],
                    ['description' => 'Replace the "storage" slot with a "session" slot in every factories.{yaml,xml,php}. If you had NullStorage, just DELETE the slot -- a context with no session entry gets a NullSessionBag, which is exactly what NullStorage expressed.', 'code' => <<<'YAML'
                        # Before
                        storage:
                          class: Quiote\Storage\PdoSessionStorage
                          params:
                            database: sessions
                            db_table: session

                        # After
                        session:
                          class: Quiote\Session\PdoSessionFactory
                          params:
                            database: sessions
                            table: session
                        YAML],
                    ['description' => 'Replace Context::getStorage() with Context::getSessionBag() and map the method names: retrieve($k) -> get($k), retrieve($k) ?? $d -> get($k, $d), store($k,$v) -> set($k,$v), remove -> remove, regenerate -> regenerate. New: has(), exists(), getId(), destroy(). Note get() now returns your default for "missing" -- SessionStorage::retrieve() answered null and NullStorage::retrieve() answered false, and code only survived that difference through loose comparison.'],
                    ['description' => 'THE CHANGE MOST LIKELY TO BREAK YOU SILENTLY: if you subclass User, SecurityUser or RbacSecurityUser, the hierarchy now tracks whether a request actually changed anything and writes nothing when it did not. A subclass that mutates $attributes/$credentials/$roles DIRECTLY, or overrides a mutator without calling parent::, is invisible to that tracking and stops persisting -- with no error. Audit for direct writes before upgrading.', 'code' => <<<'PHP'
                        // Invisible to dirty tracking -- silently stops persisting:
                        $this->attributes[$ns]['userId'] = $id;

                        // Either go through the mutator:
                        $this->setAttribute('userId', $id, $ns);

                        // ...or say so explicitly (markDirty() is public and exists for this):
                        $this->attributes[$ns]['userId'] = $id;
                        $this->markDirty();
                        PHP],
                    ['description' => 'Removed classes: Quiote\Storage\Storage, NullStorage, SessionStorage, PdoSessionStorage, Quiote\Storage\Pdo\PdoSessionStorage, Quiote\Runtime\Session\NativeSessionCookieBridge. WorkerLoop\'s constructor no longer takes a sessionCookies argument -- drop it if you construct one yourself. Quiote\Middleware\SessionMiddleware keeps its FQCN, so middleware ordering config and before:/after: anchors still resolve; it now drives the configured backend.'],
                    ['description' => 'Behaviour changes needing no code edit but worth checking for: (1) anonymous requests no longer create a session or emit a cookie -- audit anything assuming every visitor has a session id; (2) setAuthenticated(false) now discards session contents and rotates the id, so nothing survives a logout; (3) user state is persisted BEFORE the response is emitted, so anything mutating the user after the pipeline unwind (late middleware below SessionMiddleware, a worker-completed listener) no longer persists and must move above SessionMiddleware; (4) requests marked auth.sessionless or jwt.skip_session write no user state at all.'],
                    ['description' => 'Also in 3.0, unrelated to sessions but worth copying: dunglas/frankenphp reads /etc/frankenphp/Caddyfile, NOT /etc/caddy/Caddyfile. An image copying its Caddyfile to the latter has it silently ignored and starts in classic mode rather than worker mode. Check your own Dockerfile. See quiote-docs://getting-started/upgrading-to-3 for the full checklist.'],
                ],
            ],
            'request-dto' => [
                'title' => 'Declare an action\'s input as a #[MapRequest] DTO',
                'steps' => [
                    ['description' => 'Instead of naming every field twice -- once in a validator, once in getParameter() calls -- describe the shape once as a constructor-promoted class and receive it typed. This is a third way to declare input alongside the fluent builder and validators.xml; all three compile to the same validators, so they mix freely.', 'code' => <<<'PHP'
                        <?php
                        namespace App\Modules\Blog\Dto;

                        use Quiote\Request\Attribute\Constraint\Email;
                        use Quiote\Request\Attribute\Constraint\StringLength;
                        use Quiote\Request\Attribute\MapRequest;

                        #[MapRequest]
                        final readonly class ContactDto
                        {
                            public function __construct(
                                #[StringLength(min: 2, max: 20)] public string $title,
                                #[Email] public ?string $authorEmail = null,
                            ) {}
                        }
                        PHP],
                    ['description' => 'Add it as a second parameter to the execute* method that handles the request. There is no other registration step -- no registerValidators() override, no validator file. The DTO is bound to that ONE method, so each verb can declare its own input shape (or none).', 'code' => <<<'PHP'
                        public function executeWrite(WebRequest $rd, ContactDto $dto): string
                        {
                            // $dto is only constructed once validation has already passed.
                            $this->mailer->send($dto->authorEmail, $dto->title);
                            return 'Success';
                        }
                        PHP],
                    ['description' => 'Constraints (all accept message:): #[NotBlank], #[StringLength(min,max)], #[Range(min,max)], #[Email], #[Choice(values)], #[Regexp(pattern, match)], #[BooleanType], #[JsonType], #[DateTimeType]. A property may carry several. REQUIRED-NESS COMES FROM THE CONSTRUCTOR SIGNATURE, not an attribute: no default value + non-nullable type means required, everything else is optional -- which is why ?string $authorEmail = null above is an optional email.'],
                    ['description' => 'A property with no constraint attribute still gets a minimal type-inferred validator -- that is not decoration, it is what puts the name on WebRequest\'s strict-validation whitelist so the DTO can be constructed at all. Supported types: string, int/float (already cast), bool (already literalized, so "on"/"1"/"true" work), array (or a JSON string decoded -- pair with #[JsonType]), DateTimeImmutable (pair with #[DateTimeType]), and backed enums (resolved via from(); pair with #[Choice]). Hard requirement: a SINGLE NAMED TYPE per property -- no unions, no intersections, no untyped properties, or RequestDtoScanner throws naming the offending property.'],
                    ['description' => 'Because this registers real validators on the same validation manager as everything else, you inherit the whole stack: a failure produces the identical 400 and RFC 9457 application/problem+json document, $rd->getParameter() still works for the DTO\'s fields (and still throws for anything undeclared), and ActionInputSchemaResolver derives the action\'s MCP tool inputSchema and OpenAPI operation parameters from it automatically. See quiote-docs://basics/validation.'],
                ],
            ],
            'stream-sse' => [
                'title' => 'Stream Server-Sent Events from an action',
                'steps' => [
                    ['description' => 'Everything else in Quiote\'s response pipeline is string-buffered -- a View\'s return value is cast to a final string before DispatchMiddleware sees it. SseStreamingAction is the one deliberate exception. Implement the interface on an ordinary action and yield events from streamEvents().', 'code' => <<<'PHP'
                        <?php
                        namespace App\Modules\Live\Actions;

                        use Quiote\Action\Action;
                        use Quiote\Http\Sse\SseEvent;
                        use Quiote\Http\Sse\SseStreamingAction;
                        use Quiote\Request\WebRequest;

                        class TickerAction extends Action implements SseStreamingAction
                        {
                            public function isSimple(): bool { return true; }

                            public function streamEvents(WebRequest $request): iterable
                            {
                                for ($i = 0; $i < 10; $i++) {
                                    yield SseEvent::of(['tick' => $i], event: 'tick');
                                    sleep(1);
                                }
                            }
                        }
                        PHP],
                    ['description' => 'streamEvents() may return any iterable of SseEvent or plain string (a string is wrapped as a data-only event) -- but use a GENERATOR, since that is what makes events arrive one at a time rather than all at the end. Build events with SseEvent::of(string|array $data, ?string $event, ?string $id, ?int $retryMs), which JSON-encodes an array argument for you; the raw constructor takes a string. "event" names the type so the client can addEventListener(\'tick\', ...), "id" sets the last-event-id sent back on reconnect, and "retryMs" tells the browser how long to wait before reconnecting.'],
                    ['description' => 'The response is built for you with the headers a stream needs: Content-Type: text/event-stream, Cache-Control: no-cache, Connection: keep-alive, and X-Accel-Buffering: no -- that last one stops nginx and Caddy holding your events and delivering them in one lump, which is the usual reason a stream "works locally but not in production".'],
                    ['description' => 'A streaming action is a PARALLEL DISPATCH PATH, not a new output type: DispatchMiddleware detects the interface and short-circuits. So it bypasses the View layer entirely (no View, no Template, no output type to declare -- streamEvents() IS the response body), caching, and validation-decision bridging. Reach for the request object directly if the stream is parameterised. See quiote-docs://advanced/server-sent-events for how streaming behaves per worker runtime.'],
                ],
            ],
            'store-files' => [
                'title' => 'Read and write files through the filesystem abstraction',
                'steps' => [
                    ['description' => 'Quiote\Filesystem gives application code one interface over a named "disk", so a local directory in development and an object store in production differ only by config. It is deliberately separate from sessions and the cache -- this is for files your application owns (generated reports, user uploads, exported archives). It lives in core but is a PLUGIN, so it must be activated or FilesystemManager will not exist.', 'code' => <<<'PHP'
                        <?php
                        // Config/plugins.php
                        return [
                            ['class' => \Quiote\Filesystem\FilesystemPlugin::class],
                        ];
                        PHP],
                    ['description' => 'The four most common operations are on the manager itself and go to the default disk; go through disk() for anything else or to target a specific one. disk() resolves the alias through the driver registry and the container, so a disk is a long-lived memoized service, not rebuilt per call.', 'code' => <<<'PHP'
                        use Quiote\Filesystem\FilesystemManager;

                        $fs = $this->getContext()->getContainer()->get(FilesystemManager::class);

                        $fs->write('reports/2026-q3.csv', $csv);
                        $csv = $fs->read('reports/2026-q3.csv');
                        $fs->exists('reports/2026-q3.csv');
                        $fs->delete('reports/2026-q3.csv');

                        $fs->disk()->size('reports/2026-q3.csv');           // default disk
                        $fs->disk('s3')->write('exports/big.zip', $bytes);  // a named disk
                        PHP],
                    ['description' => 'FilesystemAdapterInterface is: read (throws FileNotFoundStorageException if absent), write (creates or overwrites), delete (best-effort, a no-op if absent), exists, size, lastModified (both throw if absent), and listContents (relative paths, NON-RECURSIVE). Everything thrown extends Quiote\Filesystem\FilesystemStorageException, so catching the base type catches the whole subsystem.'],
                    ['description' => 'Configure the core "local" disk. Every path resolves against a fixed root; .. segments and absolute paths are rejected (load-bearing here in a way it is not for sessions, since callers may pass user input straight in), and writes are atomic via temp-file-then-rename so a reader never sees a partial file. The root is created at 0755 if missing, and a non-writable root fails at construction rather than at first write.', 'code' => <<<'YAML'
                        # Config/settings.yaml
                        filesystem.default_disk: local
                        filesystem.disks.local.root: storage/app
                        YAML],
                    ['description' => 'Cloud disks are one package + plugin each: s3 (filesystem-s3, Quiote\Filesystem\S3\S3FilesystemPlugin), gcs (filesystem-gcs, Gcs\GcsFilesystemPlugin), azure (filesystem-azure, Azure\AzureFilesystemPlugin). Set that disk\'s filesystem.disks.<alias>.* settings and bind a PSR-18 client. read/write/delete/exists/size/lastModified all work against both local and cloud; exists() on a cloud disk issues a HEAD rather than a GET, so it does not transfer the body.'],
                    ['description' => 'CAUTION: listContents() throws UNCONDITIONALLY on all three cloud disks -- the underlying REST clients implement get/put/delete/head on a single object and have no list operation at all. That is a current limitation, not a transient failure, and no retry or different bucket fixes it. If you need a listing in production, keep it yourself in the database alongside whatever record owns the file. Also out of scope by design: visibility/ACLs, MIME detection, streaming reads/writes, copy/move, and checksums -- use the disk\'s own client for those. See quiote-docs://basics/filesystem.'],
                ],
            ],
            'generate-openapi' => [
                'title' => 'Generate an OpenAPI spec from routes and validators',
                'steps' => [
                    ['description' => 'openapi:generate writes an OpenAPI 3.1 document that is DERIVED, not maintained -- there is no second, hand-written description sitting next to the code waiting to drift. Paths and verbs come from the route table, parameters and request bodies from each action\'s validators, the success media type from the route\'s output type, error responses from Quiote\Http\ProblemDetails, and operation prose from the action class\'s docblock. Add a route and it appears; add a validator and the parameter appears with its constraints.', 'code' => <<<'BASH'
                        vendor/bin/quiote openapi:generate -o openapi.json
                        vendor/bin/quiote openapi:generate --format=yaml
                        vendor/bin/quiote openapi:generate --module=Orders --exclude='internal.*'
                        vendor/bin/quiote openapi:generate --title='Orders API' --api-version=2.1.0
                        BASH],
                    ['description' => 'The output format is inferred from the -o extension, or forced with --format. To get richer output, declare validators -- parameter placement follows what the pipeline actually reads: a parameter whose name is a path placeholder becomes a path parameter; on the bodyless verbs (GET, HEAD, DELETE, OPTIONS, TRACE) the rest become query parameters; on the others they become a requestBody offered as BOTH application/json and application/x-www-form-urlencoded, because PayloadParsingMiddleware genuinely parses both into the same request parameters.'],
                    ['description' => 'Know the four deliberate limits before publishing the output. (1) RESPONSE BODIES ARE NOT DESCRIBED -- an action returns a view name and the view renders whatever it likes, so each success response states only its media type and leaves the schema unconstrained; merge schemas in after generation if you need them. (2) An action with no validators contributes an operation with no parameters beyond its path placeholders -- that is absence of knowledge, not a claim that it accepts nothing. (3) Optional path placeholders (/list/{page?1}) become REQUIRED path parameters carrying that default, because OpenAPI has no notion of an optional path parameter. (4) Action docblocks are published as operation prose.'],
                    ['description' => 'That last one matters if your docblocks read as internal notes rather than API documentation -- turn it off with core.openapi.use_action_docblocks: false or --no-docblocks. Error responses are on by default via core.openapi.problem_responses: a 400 wherever an action declares validators, a 500 always, plus a referenced ProblemDetails component schema.'],
                    ['description' => 'The parameter half comes from Quiote\Validator\Compiler\JsonSchema\ActionInputSchemaResolver -- the SAME derivation that gives an MCP tool its inputSchema, reading both validator conventions (the Validate/ file convention and the fluent register{Method}Validators() hook), #[MapRequest] DTOs included. So one validator declaration drives HTTP validation, the OpenAPI operation, and the MCP tool schema. See quiote-docs://advanced/openapi.'],
                ],
            ],
            'authenticate-user' => [
                'title' => 'Authenticate requests with a firewall (form login, HTTP Basic, JWT, OIDC)',
                'steps' => [
                    ['description' => 'The auth model is a FIREWALL: for a slice of your app\'s URL space (a path pattern), it says how a caller proves who they are and what happens if they can\'t. It is not a network firewall and blocks nothing itself. A Firewall is a plain, immutable 5-arg value object; a FirewallMap holds an ordered list and matches the FIRST pattern that fits the raw request path -- no "most specific wins" logic, so list narrower patterns (^/api/) before broader ones (^/) or the catch-all always wins and api never matches.', 'code' => <<<'BASH'
                        composer require quioteframework/auth
                        BASH],
                    ['description' => 'Two independent flags per firewall, easy to conflate: `stateless` (identity axis) -- true means the identity is re-derived from the credential every request (HTTP Basic, bearer/JWT); false means it is read back from the session between requests (form login). `sessionless` (session axis) -- true means no session/cookie is started at all for this firewall\'s requests (pure M2M). Exactly one of StatelessAuthenticationMiddleware / SessionAuthenticationMiddleware acts on a given request, decided entirely by the matched firewall\'s `stateless` flag.', 'code' => <<<'PHP'
                        <?php
                        use Quiote\Security\Auth\{Firewall, FirewallMap};
                        use Quiote\Security\Auth\EntryPoint\{HttpChallengeEntryPoint, LoginRedirectEntryPoint};
                        use App\Auth\{Authenticator\HttpBasicAuthenticator, Provider\InMemoryUserProvider, Hasher\DefaultPasswordHasher};

                        $hasher = new DefaultPasswordHasher(); // argon2id, falls back to bcrypt
                        $provider = new InMemoryUserProvider([
                            'alice@example.com' => ['password_hash' => $hasher->hash('secret'), 'roles' => ['admin']],
                        ]);

                        $firewalls = new FirewallMap([
                            // Narrower pattern first: this is /api/, not the catch-all below.
                            new Firewall('api', '^/api/', [new HttpBasicAuthenticator($provider, $hasher)], new HttpChallengeEntryPoint(), stateless: true),
                            new Firewall('main', '^/', [$formLoginAuthenticator], new LoginRedirectEntryPoint('/login')),
                        ]);
                        PHP],
                    ['description' => 'Register the FirewallMap from a plugin\'s register() -- AuthPlugin ships an EMPTY FirewallMap and no-op middleware by default, so nothing is protected until you bind a populated one yourself.', 'code' => <<<'PHP'
                        <?php
                        // Inside your plugin's register(PluginRegistrar $registrar): void
                        $registrar->service(\Quiote\Security\Auth\FirewallMap::class, static fn() => $firewalls);
                        PHP],
                    ['description' => 'Form login additionally wants CsrfManager and/or LoginThrottle -- both are soft dependencies of FormLoginAuthenticator, pass null to skip either. This is deliberately redundant with CsrfValidationMiddleware (which already checks every unsafe request) -- the authenticator\'s own check stays correct even if that middleware is disabled or reordered for some other route.', 'code' => <<<'PHP'
                        <?php
                        use App\Auth\Authenticator\FormLoginAuthenticator;
                        use Quiote\Security\Csrf\CsrfManager;
                        use Quiote\Security\RateLimit\{LoginThrottle, PdoRateLimiterStorage};

                        $formLoginAuthenticator = new FormLoginAuthenticator(
                            $provider, $hasher,
                            checkPath: '/login',
                            csrf: new CsrfManager($context),
                            throttle: new LoginThrottle(new PdoRateLimiterStorage($conn)),
                        );
                        PHP],
                    ['description' => 'For a bearer/JWT resource server (an API that ACCEPTS tokens someone else minted -- a human\'s access token or a service\'s M2M token, both), add quioteframework/auth-jwt. JwtAuthPlugin only registers the ClientTypeResolverInterface default -- the validator and authenticator need app-specific secrets, so wire those yourself.', 'code' => <<<'PHP'
                        <?php
                        // composer require quioteframework/auth-jwt
                        use App\Auth\Authenticator\BearerTokenAuthenticator;
                        use App\Auth\JwtTokenValidator;

                        $validator = new JwtTokenValidator(/* HS256 secret, or RS256/ES256 via a JWKS-backed CachedKeySet */);
                        $bearerAuth = new BearerTokenAuthenticator($validator);
                        // ...use $bearerAuth in a stateless: true Firewall, as above.
                        PHP],
                    ['description' => 'For Quiote as an OAuth/OIDC CLIENT (never an authorization server), add quioteframework/auth-oauth. Two distinct flows sharing one package: relying party (redirect a human to Entra ID/Google/Okta -- OidcClient + OidcAuthenticator, PKCE S256 hardcoded) vs. outbound M2M (ClientCredentialsClient, Quiote fetching its own token to call another API, no browser). No plugin ships with this package -- every piece needs app-specific secrets/endpoints. Don\'t reach for this when you actually need auth-jwt (resource server) -- see quiote-docs://advanced/authentication-authorization\'s decision guide.', 'code' => <<<'PHP'
                        <?php
                        // composer require quioteframework/auth-oauth
                        $discovery = \App\Auth\OidcDiscoveryClient::discover('https://issuer.example.com');
                        $oidc = \App\Auth\OidcClient::fromDiscovery($discovery, clientId: '...', clientSecret: '...', redirectUri: '...');
                        // $oidc->buildAuthorizationRequest() to start the redirect; OidcAuthenticator handles the callback leg.
                        PHP],
                    ['description' => 'Securing an action itself is unchanged by any of this -- isSecure(): bool and getCredentials() (AND/OR shape via hasCredentials([\'edit\', [\'admin\', \'moderator\']])) on the action, still decided by SecurityMiddleware/SecurityService::decide(). A firewall only establishes WHO the caller is; it never makes the authorization decision. See quiote-docs://advanced/authentication-authorization.'],
                ],
            ],
            'secure-mcp-endpoint' => [
                'title' => 'Secure the MCP HTTP endpoint with a bearer token or OAuth2',
                'steps' => [
                    ['description' => 'The HTTP transport (mcp.transports containing "http") is safe by default: with no mcp.auth_token configured, Quiote\Mcp\Auth\StaticTokenAuthenticator rejects EVERY request rather than silently allowing them through. Set a token, typically from the environment.', 'code' => <<<'PHP'
                        <?php
                        // Config/settings.php
                        return [
                            'mcp.transports' => ['stdio', 'http'],
                            'mcp.auth_token' => getenv('QUIOTE_MCP_TOKEN') ?: null,
                        ];
                        PHP],
                    ['description' => 'For a trusted network, or a reverse proxy that already authenticates, mcp.auth = \'none\' is the explicit, deliberate opt-out -- it also skips registering McpAuthMiddleware entirely. Do not reach for this just to make a 401 go away during development; set mcp.auth_token instead.'],
                    ['description' => 'mcp.auth = \'oauth2\' makes the endpoint a real OAuth2 RESOURCE SERVER: bearer tokens are validated as JWTs against the issuer\'s JWKS, and RFC 9728 protected-resource metadata is served at the well-known path so a client can discover where to get a token. This composes the MCP SDK\'s own OIDC discovery, JWKS provider, token validator and authorization middleware -- which is why McpAuthMiddleware is NOT registered in this mode; enforcement lives inside the SDK transport\'s own middleware stack.', 'code' => <<<'PHP'
                        <?php
                        // Config/settings.php
                        return [
                            'mcp.auth' => 'oauth2',
                            'mcp.oauth.issuer' => 'https://issuer.example.com',
                            'mcp.oauth.audience' => 'my-mcp-server',
                            'mcp.oauth.jwks_uri' => null,                 // optional, bypasses OIDC discovery
                            'mcp.oauth.scopes_supported' => ['mcp:read', 'mcp:write'],
                            'mcp.oauth.cache_ttl' => 3600,                // seconds a fetched JWKS is cached
                        ];
                        PHP],
                    ['description' => 'Both middlewares -- McpAuthMiddleware (bearer/oauth2 modes) and McpEndpointMiddleware -- are anchored before: SecurityMiddleware, since MCP does its own auth rather than session-based security/CSRF. There is still no RBAC-gated tool listing and no rate limiting on the HTTP endpoint in any auth mode -- a caller\'s roles don\'t filter tools/list, and neither mode throttles calls; that is a documented current gap, not a misconfiguration to chase. See quiote-docs://advanced/mcp-server.'],
                ],
            ],
            'harden-http-surface' => [
                'title' => 'Add CORS, security headers, and general HTTP rate limiting',
                'steps' => [
                    ['description' => 'Three independent, opt-in packages -- none of them the login-specific LoginThrottle from the "throttle-login" recipe, which only guards one action. Install whichever apply; none require the others.', 'code' => <<<'BASH'
                        composer require quioteframework/cors
                        composer require quioteframework/security-headers
                        composer require quioteframework/ratelimit
                        BASH],
                    ['description' => 'CORS answers preflight OPTIONS and decorates cross-origin responses -- off until cors.enabled is true, and it runs after routing/before dispatch. allowed_origins: [\'*\'] combined with allow_credentials: true is REFUSED AT BOOT with a ConfigurationException -- the fetch spec forbids sending both, and reflecting the caller\'s origin instead would grant every origin on the internet credentialed access. Enumerate real origins, or turn credentials off.', 'code' => <<<'PHP'
                        <?php
                        // Config/plugins.php
                        return [
                            ['class' => \Quiote\Security\Cors\CorsPlugin::class],
                        ];
                        // Config/settings.php
                        return [
                            'cors.enabled' => true,
                            'cors.allowed_origins' => ['https://app.example.com'],
                            'cors.allow_credentials' => true,
                            'cors.allowed_methods' => 'GET, POST, PUT, PATCH, DELETE, OPTIONS',
                            'cors.max_age' => 3600,
                        ];
                        PHP],
                    ['description' => 'Security headers apply conservative defaults to EVERY response, including error responses (it runs in the bootstrap phase) -- and only DEFAULTS each header, so an action that set one itself keeps its own value. Enabled by default once the plugin is registered; the default CSP (default-src \'self\') is deliberately strict enough to break an app loading third-party scripts/styles/fonts, so set your own rather than removing the header.', 'code' => <<<'PHP'
                        <?php
                        // Config/plugins.php
                        return [
                            ['class' => \Quiote\Security\Headers\SecurityHeadersPlugin::class],
                        ];
                        // Config/settings.php -- override only what your app actually needs to relax
                        return [
                            'security_headers.csp' => "default-src 'self'; script-src 'self' https://cdn.example.com",
                        ];
                        PHP],
                    ['description' => 'General HTTP rate limiting (as opposed to LoginThrottle, which is a plain library you wire in yourself) needs RateLimitPlugin registered AND ratelimit.http.enabled = true -- it runs in the pre_routing phase, so an over-limit request is rejected before any route resolution, and responds with an RFC 9457 problem document.', 'code' => <<<'PHP'
                        <?php
                        // Config/plugins.php
                        return [
                            ['class' => \Quiote\Security\RateLimit\RateLimitPlugin::class],
                        ];
                        // Config/settings.php
                        return [
                            'ratelimit.http.enabled' => true,
                            'ratelimit.http.max_requests' => 60,
                            'ratelimit.http.window' => '1 minute',
                        ];
                        PHP],
                    ['description' => 'ratelimit.http.trust_forwarded_for defaults to false DELIBERATELY -- trusting a client-supplied X-Forwarded-For by default lets any caller spoof a fresh key and buy unlimited requests. Only enable it behind a proxy you control, and set ratelimit.http.trusted_proxy_hops to how many of your own proxies sit in front of the app -- the address is read from the RIGHT of the header, skipping that many entries, since a proxy APPENDS rather than replaces and the leftmost value is whatever the client wrote.'],
                    ['description' => 'ratelimit.storage defaults to memory, which is PER-PROCESS -- fine for single-worker dev, useless as a shared limit across a worker pool. For a real deployment set ratelimit.storage: redis (see the "use-redis-backends" recipe) or bind PdoRateLimiterStorage yourself for shared state with no Redis dependency; the plugin binds its own storage set-if-absent, so an app binding wins. See quiote-docs://plugins/official-packages.'],
                ],
            ],
            'use-redis-backends' => [
                'title' => 'Back cache, sessions, the queue, or rate limiting with Redis',
                'steps' => [
                    ['description' => 'Four subsystems can be Redis-backed, and they don\'t share a package -- cache and rate limiting live in the kernel/ratelimit respectively, queue and session are their own packages -- but all four go through Symfony\'s RedisAdapter::createConnection() DSN factory, so ANY of ext-redis, ext-relay, or predis/predis works. predis/predis is the easiest path since it needs no PHP extension.', 'code' => <<<'BASH'
                        composer require predis/predis
                        BASH],
                    ['description' => 'Cache: one setting, no package to install (Redis support ships in the kernel).', 'code' => <<<'PHP'
                        <?php
                        // Config/settings.php
                        return [
                            'core.cache_backend' => 'redis',
                            'core.redis_dsn' => 'redis://127.0.0.1:6379',
                        ];
                        PHP],
                    ['description' => 'Sessions: install quioteframework/session-redis and name Quiote\Session\Redis\RedisSessionFactory in the "session" factory slot. Redis expires stale sessions itself via SETEX (no GC pass to schedule, unlike the file/PDO backends).', 'code' => <<<'BASH'
                        composer require quioteframework/session-redis predis/predis
                        BASH],
                    ['description' => 'Session factory config -- parameters are dsn, prefix, ttl (seconds).', 'code' => <<<'YAML'
                        # Config/factories.yaml
                        session:
                          class: Quiote\Session\Redis\RedisSessionFactory
                          params:
                            dsn: 'redis://127.0.0.1:6379'
                            prefix: 'quiote_session'
                            ttl: 7200
                        YAML],
                    ['description' => 'Queue: install quioteframework/queue-redis and point queue.default_driver at redis. Unlike queue-db, this driver\'s connection is self-contained (built from a DSN, no dependency on DatabaseManager) and needs no schema/migration step -- see the "background-job" recipe for the full RedisQueueDriver picture (RPOPLPUSH reservation, a delayed ZSET).'],
                    ['description' => 'Rate limiting: point ratelimit.storage at redis (see the "harden-http-surface" recipe for the rest of the ratelimit.http.* settings).', 'code' => <<<'PHP'
                        <?php
                        // Config/settings.php
                        return [
                            'ratelimit.storage' => 'redis',
                            'ratelimit.redis.dsn' => 'redis://127.0.0.1:6379',
                        ];
                        PHP],
                    ['description' => 'The filesystem/APCu cache backends and file-backed sessions are NODE-LOCAL -- fine for a single host, wrong the moment you put two hosts behind a load balancer with no shared filesystem (a session lands on whichever host created it; the next request elsewhere finds nothing, and the user appears logged out at random). Selecting a Redis backend with no client available raises a clear exception naming the setting rather than silently degrading to process-local storage -- deliberate, since a rate limiter or session store silently going process-local is a security problem, not just a performance one. See quiote-docs://plugins/official-packages (Redis backends section).'],
                ],
            ],
            'switch-worker-runtime' => [
                'title' => 'Run the app under RoadRunner or Swoole instead of FrankenPHP',
                'steps' => [
                    ['description' => 'The worker runtime is a seam (Quiote\Runtime\Worker\WorkerRuntimeInterface), not a fixed part of the framework -- the same application code runs under sapi, frankenphp, roadrunner, and swoole; the kernel picks one at startup. If you have no particular reason to choose otherwise, stay on FrankenPHP: it\'s a real SAPI, so nothing below applies and it needs no extra package or entrypoint. Reach for this recipe only when you specifically need RoadRunner or Swoole.'],
                    ['description' => 'RoadRunner: detection is automatic (RoadRunner sets $RR_MODE=http for its workers), and it needs a SECOND entrypoint next to pub/index.php.', 'code' => <<<'BASH'
                        composer require quioteframework/worker-roadrunner
                        composer require --dev spiral/roadrunner-cli && vendor/bin/rr get-binary
                        # or scaffold both worker.php and .rr.yaml at once:
                        # vendor/bin/quiote new . --force --runtime=roadrunner
                        BASH],
                    ['description' => 'worker.php (application root) and .rr.yaml -- pinning worker_runtime is belt-and-braces (detection already works off $RR_MODE), but keep it: an explicit runtime that turns out not to be hosting the process fails at STARTUP rather than silently degrading to one-request-per-process.', 'code' => <<<'PHP'
                        <?php
                        // worker.php
                        require __DIR__ . '/vendor/autoload.php';
                        Quiote\Runtime\Kernel::create([
                            'app_dir'        => __DIR__,
                            'env'            => getenv('QUIOTE_ENV') ?: 'production',
                            'worker_runtime' => 'roadrunner',
                        ])->run();
                        PHP],
                    ['description' => 'Activate the plugin, then run `rr serve` (or `quiote serve --runtime=roadrunner`). Only setting: worker.roadrunner.chunk_size (default 8192, an upper bound on bytes per streamed frame).', 'code' => <<<'XML'
                        <!-- Config/plugins.xml -->
                        <plugin class="Quiote\Runtime\RoadRunner\WorkerRoadRunnerPlugin"/>
                        XML],
                    ['description' => 'Swoole is the one runtime requiring an EXPLICIT opt-in -- extension_loaded(\'swoole\') alone is not evidence of running under a Swoole server (it\'s routinely loaded under php-fpm too), so auto-claiming on it would hijack every FPM request on such a box.', 'code' => <<<'BASH'
                        pecl install swoole   # 5.1 or newer
                        composer require quioteframework/worker-swoole
                        # vendor/bin/quiote new . --force --runtime=swoole   # scaffolds swoole.php
                        BASH],
                    ['description' => 'Activate the plugin and run via `quiote swoole:serve` / `quiote serve --runtime=swoole` (both set $QUIOTE_WORKER_RUNTIME=swoole for you), or `php swoole.php` directly. Concurrency knob is worker.swoole.worker_num, NOT coroutines -- worker.swoole.enable_coroutine raises an error naming the unsafe state, because Config/Context/PluginManager/RoutingCallbackPool/LogContext are all process-global and interleaved coroutines would cross-contaminate them.', 'code' => <<<'XML'
                        <!-- Config/plugins.xml -->
                        <plugin class="Quiote\Runtime\Swoole\WorkerSwoolePlugin"/>
                        XML],
                    ['description' => 'What changes off-SAPI (RoadRunner and Swoole both run under the CLI SAPI, not the sapi/frankenphp runtimes): $_FILES has no tmp_name (use $request->getUploadedFiles(); under Swoole the temp file is deleted at request end, so moveTo() must happen DURING the request -- an upload can\'t be handed to a queued job). header()/setcookie() are no-ops -- set headers on the PSR-7 response instead. Stray echo outside a template is captured per core.worker.stray_output (append/discard/throw) rather than sent. Log to php://stderr, not stdout. See quiote-docs://architecture/deployment for the full runtime comparison table and Docker/FrankenPHP setup.'],
                ],
            ],
            'test-http-endpoint' => [
                'title' => 'Test a full request end to end with the fluent HTTP client',
                'steps' => [
                    ['description' => 'Pick your test entry point by how much of the request you need to exercise: a plain service/model -- Quiote\Testing\UnitTestCase, resolve it from the context and call it directly (the default, reach for it first). A full request -- routing, middleware, action, view, response -- Quiote\Testing\HttpTestCase, below. ActionTestCase (dispatches a single action, no routing) is explicitly a TRANSITIONAL harness in the docs; prefer HttpTestCase or UnitTestCase for new tests.'],
                    ['description' => 'HttpTestCase drives the request through Context::handle() -- the SAME entry point production traffic uses, with the app\'s real middleware pipeline in place. Every request method returns a chainable TestResponse.', 'code' => <<<'PHP'
                        <?php
                        namespace Tests\Feature;

                        use Quiote\Testing\HttpTestCase;

                        final class OrdersTest extends HttpTestCase
                        {
                            public function testCreatingAnOrderReturnsItsId(): void
                            {
                                $this->post('/orders', ['sku' => 'WIDGET-1', 'qty' => 3])
                                    ->assertCreated()
                                    ->assertJson(['sku' => 'WIDGET-1']);
                            }

                            public function testAnUnknownOrderIs404(): void
                            {
                                $this->get('/orders/99999')->assertNotFound();
                            }
                        }
                        PHP],
                    ['description' => 'Request methods: get($uri, $headers) (no body), post/put/patch/delete($uri, $data, $headers) (form-encoded), json($method, $uri, $data, $headers) (JSON body -- $method is the verb, first argument, so json(\'PUT\', \'/orders/1\', [...]) covers a JSON PUT). An explicit Content-Type in $headers always wins over the default. Set protected ?string $contextName on the test class to dispatch through a non-default context.'],
                    ['description' => 'TestResponse assertions, all chainable: assertStatus($code), assertOk()/assertCreated()/assertNoContent(), assertUnauthorized()/assertForbidden()/assertNotFound(), assertRedirect($uri = null), assertHeader($name, $value = null), assertSee()/assertDontSee() (substring), assertJsonEquals() (exact), assertJson() (subset), assertJsonFragment() (subset of the body, or of any one list element), assertXml() (canonicalized), assertHasXPath($expr). For anything else: getPsrResponse(), getStatusCode(), getHeaderLine(), getContent(), json(), xml().'],
                    ['description' => 'Register app-specific assertions on TestResponse rather than subclassing it -- extensions are process-global, so register them once in your suite bootstrap.', 'code' => <<<'PHP'
                        <?php
                        use Quiote\Testing\Http\TestResponse;

                        TestResponse::extend('assertApiError', function (string $code): TestResponse {
                            return $this->assertStatus(422)->assertJson(['error' => ['code' => $code]]);
                        });

                        // then, in any test:
                        $this->post('/orders', [])->assertApiError('sku_required');
                        PHP],
                    ['description' => 'A test needing a session installs one via the public Context::setSessionBag() (no reflection needed); passing null drops it back to a NullSessionBag (writes discarded, exists() false). For process isolation (a test that mutates locale/environment/default context and could poison sibling tests), mark the class #[RunTestsInSeparateProcesses] plus #[IsolationEnvironment(...)] -- see quiote-docs://advanced/testing for the full isolation-attribute table and the lower-level "compose the middleware stack yourself" pattern for testing one middleware in isolation.'],
                ],
            ],
            'write-custom-validator' => [
                'title' => 'Write a custom validator with the Validator base class',
                'steps' => [
                    ['description' => 'Extend Quiote\Validator\Validator and implement one method: protected abstract function validate(): bool. Return true to pass, false to fail -- but returning false ALONE records no error message. Every return false; path must also call $this->throwError() (with or without an index) before returning, or the field is correctly rejected under strict access yet no ValidationError incident is ever recorded, so nothing surfaces to the error view, the JSON problem document, or FormPopulationMiddleware. This has bitten one of the framework\'s own built-in validators -- check every failure branch individually, not just that a throwError() call exists somewhere in the class.', 'code' => <<<'PHP'
                        <?php
                        namespace App\Validator;

                        use Quiote\Validator\Validator;

                        final class StrongPasswordValidator extends Validator
                        {
                            public static function getAcceptedParameters(): array
                            {
                                return array_merge(parent::getAcceptedParameters(), ['min_score']);
                            }

                            protected function validate(): bool
                            {
                                $password = $this->getData($this->getArgument());

                                if (!is_scalar($password)) {
                                    $this->throwError();            // required -- see the caution above
                                    return false;
                                }

                                if ($this->scoreOf((string) $password) < (int) $this->getParameter('min_score', 3)) {
                                    $this->throwError();            // uses the configured <error> message
                                    return false;
                                }

                                return true;
                            }

                            private function scoreOf(string $password): int { /* ... */ }
                        }
                        PHP],
                    ['description' => 'getAcceptedParameters() must be overridden (merged with parent::) to whitelist any new config parameter -- checked at compile time, so a misspelled parameter name surfaces as an error instead of being silently ignored. The methods available inside validate(): getData($paramName), getArgument($name = null), getArguments(), getParameter($name, $default), throwError($index = null), export($value, $argument = null).'],
                    ['description' => 'Validator construction goes through the container, so (as of 4.0) a validator may take collaborators like anything else -- purely additive, every constructor-less validator (every one the framework ships, and every one written before this) is still `new`\'d directly.', 'code' => <<<'PHP'
                        <?php
                        final class VatNumberValidator extends Validator
                        {
                            public function __construct(private readonly VatLookupService $lookup) {}

                            protected function validate(): bool
                            {
                                return $this->lookup->isRegistered((string) $this->getData($this->getArgument()));
                            }
                        }
                        PHP],
                    ['description' => 'A validator is built PER VALIDATION and never cached, so unlike a singleton service it may safely depend on request-scoped state directly (WebRequest, the user) -- there is no captive-dependency problem here the way there is for a singleton. Parameters, argument names, and error messages still arrive through initialize(), not the constructor -- those are per-declaration data read out of a config file, so there is nothing for the container to resolve them from.'],
                    ['description' => 'Wire it in via Modules/{Module}/Validate/{Action}.php (recommended for new code -- no XML, no separate registration) using raw() for any class with no dedicated builder helper, or via validators.xml\'s <validator_definition>. Both compile to the same validation manager, so you can mix and migrate one action at a time.', 'code' => <<<'PHP'
                        <?php
                        use Quiote\Validator\Compiler\Runtime\ValidatorBuilder;

                        return function (ValidatorBuilder $v): void {
                            $v->raw(\App\Validator\StrongPasswordValidator::class, ['password'], ['min_score' => 3]);
                        };
                        PHP],
                    ['description' => 'See quiote-docs://advanced/custom-validators for the validators.xml format, the built-in alias table (string/number/email/regex/datetime/inarray/isset/isnotempty/json/file/imagefile, and the and/or/not/xor operator groups), and discovery/compilation details.'],
                ],
            ],
            'write-custom-renderer' => [
                'title' => 'Write a custom template renderer (Markdown, Blade, or a bespoke format)',
                'steps' => [
                    ['description' => 'A renderer is the last link in producing a response body -- it turns a template into an output STRING (never echo or exit; a string return, not writing to output, is what makes a renderer safe under worker mode). Renderers are chosen per output type through a plain config registry -- there is no renderer plugin class to register. Extend the abstract Quiote\Renderer\Renderer; only render() is abstract, everything else has a working default.', 'code' => <<<'PHP'
                        <?php
                        namespace App\Renderer;

                        use Quiote\Renderer\Renderer;
                        use Quiote\View\TemplateLayer;

                        final class MyRenderer extends Renderer
                        {
                            protected $defaultExtension = '.my';

                            public function render(
                                TemplateLayer $layer,
                                array &$attributes = [],
                                array &$slots = [],
                                array &$moreAssigns = [],
                            ): string {
                                return 'rendered: ' . $layer->getResourceStreamIdentifier();
                            }
                        }
                        PHP],
                    ['description' => 'The four inputs to render(): $layer -- call $layer->getResourceStreamIdentifier() for the resolved, extension-checked template path; NEVER do your own template-file lookup, resolution (search paths, i18n fallback) is the layer\'s job. $attributes -- the view\'s data; respect $this->extractVars/$this->varName rather than hardcoding how data is exposed. $slots -- already-rendered embedded-action output, expose under $this->slotsVarName. $moreAssigns -- extra caller-injected values ($moreAssigns[\'inner\'] is the rendered inner layer an outer shell wraps).'],
                    ['description' => 'initialize() (call parent:: or don\'t override it) reads <parameter> config into properties you don\'t reinvent: $this->varName (config key var_name, default "template"), $this->slotsVarName (slots_var_name, default "slots"), $this->extractVars (extract_vars, default false -- true exposes each attribute as its own top-level variable instead of one array under $varName), $this->defaultExtension (default_extension, including the dot), $this->assigns (maps a short template-variable name to a camel-cased Context getter, e.g. \'routing\' => \'ro\' exposes $ro = $context->getRouting()).'],
                    ['description' => 'Wire it into an output type -- a plain config-driven registry, unrelated to the plugin system, no registrar call.', 'code' => <<<'PHP'
                        <?php
                        // Config/output_types.php -- inside the "html" output type's array
                        return [
                            'default_renderer' => 'md',
                            'renderers' => [
                                'php' => ['class' => \Quiote\Renderer\PhpRenderer::class],
                                'md'  => [
                                    'class'      => \App\Renderer\MarkdownRenderer::class,
                                    'parameters' => ['var_name' => 'data'],
                                ],
                            ],
                        ];
                        PHP],
                    ['description' => 'A layer can override with a `renderer` attribute, so one output type can mix engines (XSLT for a document export beside PHP-rendered HTML). Under a persistent worker a renderer instance can outlive one request -- implement the empty marker interface Quiote\Renderer\IReusableRenderer ONLY if your instance holds no per-render mutable state (or clears it every call), so OutputType::getRenderer() builds and reuses one instance instead of constructing+initialize()-ing fresh per render; override reset() (calling parent::reset()) to null out per-render state. If in doubt, skip the marker -- per-render construction is the safe default.', 'code' => <<<'PHP'
                        <?php
                        namespace App\Renderer;

                        use Quiote\Renderer\{Renderer, IReusableRenderer};
                        use Quiote\View\TemplateLayer;

                        final class MarkdownRenderer extends Renderer implements IReusableRenderer
                        {
                            protected $defaultExtension = '.md.php';

                            public function render(TemplateLayer $layer, array &$attributes = [], array &$slots = [], array &$moreAssigns = []): string
                            {
                                $template = $layer->getResourceStreamIdentifier();
                                $scope = $this->extractVars ? $attributes : [$this->varName => $attributes];
                                $scope[$this->slotsVarName] = $slots;

                                $markdown = (static function () use ($template, $scope) {
                                    extract($scope, EXTR_SKIP);
                                    ob_start();
                                    require $template;
                                    return ob_get_clean();
                                })();

                                return $this->toHtml($markdown); // your own Markdown-to-HTML step
                            }
                        }
                        PHP],
                    ['description' => 'Optional: override getStarterTemplate(): ?string (default null) to hand make:action a minimal, syntactically valid stub in your renderer\'s own syntax, so a PHPTAL/Twig/XSLT/Markdown app gets scaffolded a .tal/.twig/.xsl/.md.php template rather than a plain PHP file its renderer would never execute. Leaving it null is fine -- make:action then writes no template and warns instead, naming the file/extension to author by hand. See quiote-docs://advanced/custom-renderers, including "shipping it as a package" if this is reusable across apps.'],
                ],
            ],
            'upgrade-to-3-2' => [
                'title' => 'Upgrade an app from Quiote 3.0/3.1 to 3.2',
                'steps' => [
                    ['description' => 'THE CHANGE MOST LIKELY TO AFFECT APPLICATION CODE: Quiote\Http\PsrResponseAdapter::with*() is now properly IMMUTABLE. Code that called ->withHeader(...) and discarded the return value used to silently mutate the shared response object (working by accident); that pattern is now a genuine no-op. Audit for any with*() call whose return value isn\'t captured.', 'code' => <<<'PHP'
                        // Before (worked by accident -- mutated the shared response in place):
                        $response->withHeader('X-Foo', 'bar');

                        // After (with*() is immutable -- capture the return value):
                        $response = $response->withHeader('X-Foo', 'bar');
                        PHP],
                    ['description' => 'WebResponse::setHttpStatusCode() now accepts the full 100-599 range instead of a per-protocol status-code table -- if you worked around a previously-rejected status code, that workaround can be dropped.'],
                    ['description' => 'Quiote\Config\Config::$config is now private -- replace any direct property access/reflection with Config::get()/set()/has()/remove()/fromArray()/toArray()/clear().'],
                    ['description' => 'Quiote\Middleware\ValidationMiddleware\'s constructor now requires a real Controller -- the null fallback is gone. If you constructed one directly (rather than through the pipeline), pass a real Controller instance.'],
                    ['description' => 'WebRequest\'s setUrl*() mutators and setProtocol() now also rewrite the wrapped PSR-7 URI, so the two stay in sync -- no code change needed, but don\'t assume the PSR-7 URI is stale after calling one of these if you were relying on the old (buggy) divergence.'],
                    ['description' => 'Session wire format is unified behind Quiote\Session\SessionCodec/SessionCodecInterface -- if you read/wrote raw session payloads outside the SessionBag API, go through the codec instead.'],
                    ['description' => 'Quiote\Filesystem\FilesystemAdapterInterface no longer declares listContents() -- it moved to Quiote\Filesystem\ListableFilesystemInterface. A custom adapter implementing listContents() should now implement this narrower interface instead. Quiote\Storage\{S3,Gcs}\ObjectMetadata and Azure\BlobMetadata are unified into one Quiote\Storage\ObjectMetadata -- update any type hints against the old per-cloud classes.'],
                    ['description' => 'CORS now throws ConfigurationException AT BOOT for cors.allowed_origins: [\'*\'] combined with cors.allow_credentials: true -- if your app had this combination (accidentally or otherwise), fix it before upgrading or the app fails to start. See the "harden-http-surface" recipe.'],
                    ['description' => 'See quiote-docs://getting-started/upgrading-to-3-2 for the full checklist.'],
                ],
            ],
            'upgrade-to-4' => [
                'title' => 'Upgrade an app from Quiote 3.x to 4.0',
                'steps' => [
                    ['description' => 'Do this ONE thing on the way in: delete the config cache directory (core.cache_dir, plus the system-temp fallback if unset) or run cache:warmup once. From 4.0 onward every compiled config cache key includes a framework fingerprint so future upgrades auto-invalidate -- but a fingerprint can\'t retroactively invalidate a cache compiled before it existed, and the compiled factories file changed shape in 4.0, so a stale pre-4.0 cache fails at boot reporting whatever its contents happen to break first, not the staleness.', 'code' => <<<'BASH'
                        rm -rf var/cache/config    # or wherever core.cache_dir points
                        # or:
                        vendor/bin/quiote cache:warmup
                        BASH],
                    ['description' => 'NOTHING HERE REQUIRES APPLICATION CHANGES beyond the cache clear above -- every Context accessor still works. Compiled config (factories, databases, output_types, translation, and now every OTHER kind too: settings, module, plugins, middleware, validators) became DATA rather than executable PHP -- only matters if you read a compiled file directly or wrote your own config handler.'],
                    ['description' => 'If you wrote a custom config handler: IXmlConfigHandler::execute() / IArrayConfigHandler::executeArray() / ILegacyConfigHandler::execute() now return the declaration (mixed), not a string of generated PHP. Quiote\Config\BaseConfigHandler::generate() is removed -- return the declaration directly. Quiote\Config\ConfigCache::writeCacheFile() takes ($config, $cache, $value, $generatedBy = null) -- no $append parameter. A handler registered for ConfigCache::load($path) must implement Quiote\Config\IDeclarationConfigHandler and move its old generated-statement logic into apply(mixed $declaration, string $sourceRef): void.'],
                    ['description' => 'Context is growing seams, not losing accessors -- new injectable classes exist for what used to be reached through the context, purely additive.'],
                    ['description' => 'Prefer constructor injection over reaching through the context in new code:', 'code' => <<<'PHP'
                        // Instead of ...                  // Inject ...
                        // $context->getModel(...)         Quiote\Model\ModelLocator
                        // Context::getInstance('web')      Quiote\ContextRegistry
                        // $context->getRequest()/setRequest()  Quiote\Request\RequestState
                        // $context->getUser()              Quiote\User\CurrentUser
                        PHP],
                    ['description' => 'TWO BREAKING SCOPE-DEFAULT FIXES, both closing real cross-request identity leaks. (1) An unregistered, autowired class with no #[Service] and no ServiceInterface used to default to SCOPE_SINGLETON -- the container\'s most dangerous default, since a singleton keeps whatever it was handed at construction for the worker\'s whole life. It now defaults to SCOPE_REQUEST. If something relied on that instance surviving across requests, register it explicitly: #[Service(scope: Container::SCOPE_SINGLETON)]. (2) A bare #[Service] (no scope: argument) used to default to singleton, disagreeing with ServiceInterface\'s transient default -- both now agree on SCOPE_TRANSIENT. Audit for a bare #[Service] attribute that relied on the old singleton default.'],
                    ['description' => 'A defect fix, not a rename: injecting WebRequest or User in a SINGLETON used to silently hand back a fresh, empty/unauthenticated instance (the container only bound each core service under its concrete class, so the app\'s WebRequest/User subclass left the base type unregistered). It now throws ContainerException AT WIRING TIME, naming RequestState/CurrentUser as the fix -- this is a real defect being surfaced, not new breakage; if it fires, replace the base-class injection with RequestState/CurrentUser per the table above.'],
                    ['description' => 'Validators can now declare constructor dependencies -- purely additive, see the "write-custom-validator" recipe. Two previously-private things are now public API: Context::getShutdownSequence() (append()/remove()/replaceRole()/all(), replacing reflection on the old array property) and Context::create() (the named constructor ContextRegistry builds through).'],
                    ['description' => 'Checklist: clear the config cache or run cache:warmup; check for anything reading a compiled config file or the old *FactoryInfo properties on Context; if you wrote a custom config handler, update it per above; check for Context::$psrKernel/$correlationId access (removed -- use $context->getRequestHandler()->pipeline()/getCorrelationId()); check singletons type-hinting WebRequest/User/ISecurityUser (now throws -- inject RequestState/CurrentUser); check for anything relying on an unregistered class behaving as a singleton, or a bare #[Service] relying on the old singleton default; register a request-end clear (PluginManager::addRequestEndClear()) for any request-scoped state your own code holds. See quiote-docs://getting-started/upgrading-to-4.'],
                ],
            ],
        ];
    }
}
