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
}
