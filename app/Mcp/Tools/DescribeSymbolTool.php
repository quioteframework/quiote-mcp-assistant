<?php
declare(strict_types=1);

namespace QuioteMcpAssistant\Mcp\Tools;

use QuioteMcpAssistant\Mcp\Reflection\FrameworkApi;

/**
 * `describe_symbol` -- reflection-based signature + docblock lookup for a
 * `Quiote\*` class/interface/trait/enum, so this never drifts from the
 * framework's actual code.
 *
 * `$symbol` is either a bare FQCN (`Quiote\Action\Action`) or `Class::method`
 * (`Quiote\Action\Action::executeRead`) to describe just one method.
 */
final class DescribeSymbolTool
{
    public function __construct(private readonly FrameworkApi $api) {}

    /** @return array<string, mixed> */
    public function describe(string $symbol): array
    {
        $symbol = ltrim(trim($symbol), '\\');
        if (str_contains($symbol, '::')) {
            $parts = explode('::', $symbol, 2);
            $fqcn = $parts[0];
            $methodName = $parts[1] ?? null;
        } else {
            $fqcn = $symbol;
            $methodName = null;
        }

        if (!$this->api->isFrameworkSymbol($fqcn)) {
            return [
                'symbol' => $symbol,
                'error' => sprintf('"%s" is outside the Quiote\\ namespace this tool describes.', $fqcn),
            ];
        }

        if (!$this->api->classLikeExists($fqcn)) {
            return [
                'symbol' => $symbol,
                'error' => sprintf('Unknown class/interface/trait/enum "%s".', $fqcn),
            ];
        }

        try {
            if ($methodName !== null) {
                $ref = new \ReflectionClass($fqcn);
                if (!$ref->hasMethod($methodName)) {
                    return [
                        'symbol' => $symbol,
                        'error' => sprintf('"%s" has no method "%s".', $fqcn, $methodName),
                    ];
                }

                return [
                    'symbol' => $symbol,
                    'fqcn' => $fqcn,
                    'method' => $this->api->describeMethod($ref->getMethod($methodName)),
                ];
            }

            return array_merge(['symbol' => $symbol], $this->api->describeClass($fqcn));
        } catch (\Throwable $e) {
            // A parent class/interface can itself sit behind a dependency this
            // app doesn't have installed (see FrameworkApi::classLikeExists()) --
            // reflecting past that point can still throw. Report it rather than
            // taking the whole stdio server down.
            return [
                'symbol' => $symbol,
                'error' => sprintf('Could not reflect "%s": %s', $fqcn, $e->getMessage()),
            ];
        }
    }
}
