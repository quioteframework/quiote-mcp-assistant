<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Tools;

use QuioteMcpAssistant\Mcp\Conventions\ConventionCards;

/**
 * `get_convention` -- return one hand-authored convention card by topic. Unknown
 * topics come back with the list of valid topics rather than an error, so the
 * agent can self-correct.
 */
final class GetConventionTool
{
    /**
     * @return array{topic: string, title?: string, body?: string, available_topics?: list<string>, error?: string}
     */
    public function get(string $topic): array
    {
        $card = ConventionCards::get($topic);
        if ($card === null) {
            return [
                'topic' => $topic,
                'error' => sprintf('No convention card for "%s".', $topic),
                'available_topics' => ConventionCards::topics(),
            ];
        }

        return [
            'topic' => strtolower(trim($topic)),
            'title' => $card['title'],
            'body' => $card['body'],
        ];
    }
}
