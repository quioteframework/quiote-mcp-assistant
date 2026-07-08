<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Introspection\Capabilities;

/**
 * File-content generators shared by `scaffold_module` and `scaffold_action`.
 * Deliberately minimal (a bare `execute()` + one attribute, no layout/theme
 * assumptions) -- this generates a valid skeleton satisfying the framework's
 * contract, not a styled page; the target app's own conventions (a shared
 * layout, a CSS framework, …) are unknown to this tool and shouldn't be
 * guessed at. See `quiote-docs://architecture/actions-and-views` and the
 * `actions` convention card (`get_convention`) for the fuller picture.
 */
final class ScaffoldTemplates
{
    private const VALID_NAME = '/^[A-Z][A-Za-z0-9]*$/';

    public static function assertValidName(string $name, string $label): void
    {
        if (!preg_match(self::VALID_NAME, $name)) {
            throw new \InvalidArgumentException(sprintf(
                'Invalid %s name "%s": expected PascalCase, e.g. "Blog" or "Post" (matching %s).',
                $label,
                $name,
                self::VALID_NAME,
            ));
        }
    }

    /**
     * The generated action carries its own `#[Route]` attribute so it's
     * reachable without ever having to edit an existing file (this tool
     * never modifies existing files -- see {@see ScaffoldWriter}). Whether
     * that attribute actually takes effect depends on the target app's
     * Routing class calling `AttributeRoutes::mergeInto()` -- true for a
     * fresh `quiote new` app, but the caller should verify with
     * `list_routes()` after applying.
     *
     * @param list<string> $verbs each one of read/write/update/remove
     */
    public static function actionContent(string $namespacePrefix, string $module, string $name, array $verbs): string
    {
        $methods = '';
        foreach ($verbs as $verb) {
            $methods .= "\n    public function execute" . ucfirst($verb) . "(WebRequest \$rd)\n"
                . "    {\n        return 'Success';\n    }\n";
        }

        $path = '/' . strtolower($module) . ($name === 'Index' ? '' : '/' . strtolower($name));

        return <<<PHP
            <?php
            namespace {$namespacePrefix}\\Modules\\{$module}\\Actions;

            use Quiote\\Action\\Action;
            use Quiote\\Request\\WebRequest;
            use Quiote\\Routing\\Attribute\\Route;

            #[Route(path: '{$path}')]
            class {$name}Action extends Action
            {
            {$methods}
                public function getDefaultViewName(): string
                {
                    return 'Success';
                }

                // No validators configured for this scaffolded action -- skip the
                // validation pipeline's lookup entirely.
                public function isSimple()
                {
                    return true;
                }
            }

            PHP;
    }

    /**
     * `View::execute()` is abstract, so it must always be implemented even
     * though every requested format below gets its own more-specific
     * `execute<Format>()` method that the framework dispatches to instead
     * (mirrors this app's own hand-written `Modules/Default/Views/*View.php`:
     * a `never`-returning `execute()` that only exists to satisfy the
     * abstract contract, never actually called in practice).
     *
     * One `execute<Format>()` method per requested output type (see
     * `quiote-docs://basics/output-types-and-content-negotiation` --
     * "Serving multiple output types from one view"): `html` calls
     * `loadLayout()` + sets attributes and lets the template layers render;
     * every other format builds and returns its body directly, since those
     * generally need no layout/template at all. Every non-template method
     * (the abstract `execute()` stub, and every non-`html` `execute<Format>()`)
     * carries `@quiote-viewmethod-has-no-template`, so `TriadDiagnosticsScanner`
     * doesn't false-flag `MISSING_TEMPLATE` for a scaffolded JSON-only (or
     * similar) action the moment it's created.
     *
     * @param list<string> $formats each one an output type name, e.g. "html"/"json"
     */
    public static function viewContent(string $namespacePrefix, string $module, string $name, array $formats): string
    {
        $methods = [];
        foreach ($formats as $format) {
            $methods[] = self::viewMethod($format, $name);
        }

        $methods = implode("\n", $methods);

        return <<<PHP
            <?php
            namespace {$namespacePrefix}\\Modules\\{$module}\\Views;

            use Quiote\\Exception\\ViewException;
            use Quiote\\Request\\WebRequest;
            use Quiote\\View\\View;

            class {$name}SuccessView extends View
            {
                /** @quiote-viewmethod-has-no-template */
                public function execute(WebRequest \$rd): never
                {
                    throw new ViewException(sprintf(
                        'The view "%1\$s" does not implement an "execute%2\$s()" method for this output type.',
                        static::class,
                        ucfirst(strtolower(\$this->getCurrentOutputType()->getName()))
                    ));
                }

            {$methods}
            }

            PHP;
    }

    private static function viewMethod(string $format, string $name): string
    {
        $methodName = 'execute' . ucfirst($format);

        if ($format === 'html') {
            return <<<PHP
                    public function {$methodName}(WebRequest \$rd): void
                    {
                        \$this->loadLayout();
                        \$this->setAttribute('title', '{$name}');
                    }

                PHP;
        }

        if ($format === 'json') {
            return <<<PHP
                    /** @quiote-viewmethod-has-no-template */
                    public function {$methodName}(WebRequest \$rd): string
                    {
                        return json_encode(['title' => '{$name}'], JSON_THROW_ON_ERROR);
                    }

                PHP;
        }

        return <<<PHP
                /** @quiote-viewmethod-has-no-template */
                public function {$methodName}(WebRequest \$rd): string
                {
                    // TODO: build and return the "{$format}" response body directly --
                    // see quiote-docs://basics/output-types-and-content-negotiation.
                    return '';
                }

            PHP;
    }

    public static function templateContent(string $name): string
    {
        return <<<PHP
            <p><?php echo htmlspecialchars(\$template['title'] ?? '{$name}', ENT_QUOTES, 'UTF-8'); ?></p>

            PHP;
    }
}
