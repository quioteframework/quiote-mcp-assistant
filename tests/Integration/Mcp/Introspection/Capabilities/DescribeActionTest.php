<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Integration\Mcp\Introspection\Capabilities;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Quiote\Context;
use Quiote\Renderer\Phptal\PhptalRenderer;
use Quiote\Renderer\Renderer;
use QuioteMcpAssistant\Mcp\Introspection\Capabilities\DescribeAction;
use ReflectionProperty;

final class DescribeActionTest extends TestCase
{
    #[Test]
    public function describesARealActionsVerbsAndClass(): void
    {
        $result = DescribeAction::run('web', 'Default', 'Contact');

        self::assertSame('QuioteMcpAssistant\Modules\Default\Actions\ContactAction', $result['class']);
        self::assertArrayHasKey('read', $result['verbs']);
        self::assertTrue($result['isSimple']);
        self::assertFalse($result['isSecure']);
    }

    #[Test]
    public function reportsNullSchemaForAnActionWithNoValidators(): void
    {
        $result = DescribeAction::run('web', 'Default', 'Contact');

        self::assertNull($result['verbs']['read']['schema']);
    }

    #[Test]
    public function reportsTheActionFileAndPerVerbLine(): void
    {
        $result = DescribeAction::run('web', 'Default', 'Contact');

        self::assertSame(1, $result['_schema_version']);
        self::assertStringEndsWith('ContactAction.php', (string) $result['file']);
        self::assertIsInt($result['verbs']['read']['line']);
    }

    #[Test]
    public function resolvesTheTriadsViewAndTemplateFiles(): void
    {
        $result = DescribeAction::run('web', 'Default', 'Contact');

        self::assertStringEndsWith('ContactSuccessView.php', (string) $result['viewFile']);
        self::assertArrayHasKey('html', $result['templateFiles']);
        self::assertStringEndsWith('ContactSuccess.php', $result['templateFiles']['html']);
    }

    /**
     * Bug A: this used to always call `templateFileFor()` with no
     * `$extension`, so it silently defaulted to `.php` no matter what
     * renderer the target app actually configured for a given output
     * type -- a PHPTAL/Twig/XSLT-rendered `executeHtml()` would always be
     * reported at the wrong (nonexistent) `.php` path. Swaps the live
     * Controller's cached "html" renderer for a real
     * `Quiote\Renderer\Phptal\PhptalRenderer` (`quioteframework/phptal`, a
     * require-dev dependency) and touches the `.tal` file the fixed code
     * should now resolve, to exercise `templateExtensionFor()` against the
     * real, bootstrapped app rather than a guess.
     */
    #[Test]
    public function resolvesThePhptalExtensionWhenHtmlIsConfiguredWithPhptal(): void
    {
        $talFile = str_replace('ContactSuccess.php', 'ContactSuccess.tal', $this->contactHtmlTemplatePath());
        self::assertFileDoesNotExist($talFile);
        touch($talFile);

        $controller = Context::getInstance('web')->getController();
        $outputTypesProp = new ReflectionProperty($controller, 'outputTypes');
        /** @var array<string, object> $outputTypes */
        $outputTypes = $outputTypesProp->getValue($controller);
        $htmlOutputType = $outputTypes['html'];

        $rendererProp = new ReflectionProperty($htmlOutputType, 'renderers');
        /** @var array<string, array{instance: ?Renderer, parameters: array<string, mixed>}> $rendererConfig */
        $rendererConfig = $rendererProp->getValue($htmlOutputType);
        $restore = $rendererConfig;

        try {
            $rendererConfig['php']['instance'] = new PhptalRenderer();
            $rendererProp->setValue($htmlOutputType, $rendererConfig);

            $result = DescribeAction::run('web', 'Default', 'Contact');

            self::assertArrayHasKey('html', $result['templateFiles']);
            self::assertStringEndsWith('ContactSuccess.tal', $result['templateFiles']['html']);
        } finally {
            $rendererProp->setValue($htmlOutputType, $restore);
            unlink($talFile);
        }
    }

    private function contactHtmlTemplatePath(): string
    {
        $result = DescribeAction::run('web', 'Default', 'Contact');
        self::assertArrayHasKey('html', $result['templateFiles']);

        return $result['templateFiles']['html'];
    }

    #[Test]
    public function rejectsAnEmptyModule(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        DescribeAction::run('web', '', 'Contact');
    }

    #[Test]
    public function rejectsAnEmptyAction(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        DescribeAction::run('web', 'Default', '');
    }

    #[Test]
    public function wrapsInstantiationFailureForANonexistentAction(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessageMatches('/Could not instantiate action "Default\.DoesNotExist"/');
        DescribeAction::run('web', 'Default', 'DoesNotExist');
    }

    #[Test]
    public function wrapsInstantiationFailureForANonexistentModule(): void
    {
        $this->expectException(\RuntimeException::class);
        DescribeAction::run('web', 'NoSuchModule', 'Contact');
    }

    /**
     * `safeCall()`/`sanitizeString()` are private, and no real Action ever
     * exercises their defensive branches (a bare Action always has all four
     * getters, and none of them throw or return a non-scalar) -- reflection
     * is the only way to reach an untrusted target app's getter genuinely
     * missing, throwing, or returning something unstringifiable.
     */
    #[Test]
    public function safeCallReturnsTheDefaultWhenTheMethodDoesNotExist(): void
    {
        $result = $this->invokeSafeCall(new class {}, 'noSuchMethod', 'the-default');

        self::assertSame('the-default', $result);
    }

    #[Test]
    public function safeCallReturnsTheDefaultWhenTheMethodThrows(): void
    {
        $thrower = new class {
            public function boom(): never
            {
                throw new \RuntimeException('an untrusted app method blew up');
            }
        };

        $result = $this->invokeSafeCall($thrower, 'boom', 'the-default');

        self::assertSame('the-default', $result);
    }

    #[Test]
    public function sanitizeStringStripsControlCharacters(): void
    {
        $result = $this->invokeSanitizeString("hello\x00\x1Fworld");

        self::assertSame('helloworld', $result);
    }

    #[Test]
    public function sanitizeStringReturnsNullForANonScalarValue(): void
    {
        self::assertNull($this->invokeSanitizeString(['not', 'a', 'scalar']));
    }

    private function invokeSafeCall(object $action, string $method, mixed $default): mixed
    {
        $ref = new \ReflectionMethod(DescribeAction::class, 'safeCall');
        return $ref->invoke(null, $action, $method, $default);
    }

    private function invokeSanitizeString(mixed $value): ?string
    {
        $ref = new \ReflectionMethod(DescribeAction::class, 'sanitizeString');
        $result = $ref->invoke(null, $value);

        return is_string($result) ? $result : null;
    }
}
