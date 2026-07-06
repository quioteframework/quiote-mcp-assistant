<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Integration\Mcp\Introspection\Capabilities;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use QuioteMcpAssistant\Mcp\Introspection\Capabilities\DescribeAction;

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
