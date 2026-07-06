<?php

declare(strict_types=1);

namespace QuioteMcpAssistant\Tests\Unit\Mcp\Conventions;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use QuioteMcpAssistant\Mcp\Conventions\ConventionCards;

/**
 * Data-integrity checks over the hand-authored cards -- catches a typo'd
 * topic key or an accidentally-empty title/body without needing to read
 * every card by eye.
 */
final class ConventionCardsTest extends TestCase
{
    #[Test]
    public function everyAdvertisedTopicResolvesToACompleteCard(): void
    {
        $topics = ConventionCards::topics();
        self::assertNotEmpty($topics);

        foreach ($topics as $topic) {
            $card = ConventionCards::get($topic);
            self::assertNotNull($card, "Topic \"{$topic}\" is listed but get() returned null.");
            self::assertNotSame('', $card['title'], "Topic \"{$topic}\" has an empty title.");
            self::assertNotSame('', trim($card['body']), "Topic \"{$topic}\" has an empty body.");
        }
    }

    #[Test]
    public function getIsCaseInsensitiveAndTrimsWhitespace(): void
    {
        $card = ConventionCards::get('  Actions  ');

        self::assertNotNull($card);
        self::assertSame(ConventionCards::get('actions'), $card);
    }

    #[Test]
    public function getReturnsNullForAnUnknownTopic(): void
    {
        self::assertNull(ConventionCards::get('nonexistent-topic'));
    }
}
