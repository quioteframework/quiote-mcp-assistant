# SamplingPolicy

> Which requests RecorderMiddleware keeps a cassette for.

Which requests [`RecorderMiddleware`](/api/replay/recording/recorder-middleware/) keeps a cassette for.

`Never` is the default so installing the package changes nothing until `replay.record` is set.

## Synopsis

`enum SamplingPolicy: string`

|  |  |
|---|---|
| Source | `Recording/SamplingPolicy.php` |

## Cases

| Case | Value | Description |
|---|---|---|
| `Never` | `'never'` |  |
| `Error` | `'error'` |  |
| `Rate` | `'rate'` |  |
| `Header` | `'header'` |  |
| `Always` | `'always'` |  |

## Properties

| Property | Type | Description |
|---|---|---|
| `$name` | `string` | _readonly._ |
| `$value` | `string` | _readonly._ |

## Methods

| Method | Description |
|---|---|
| [`cases(): array`](#cases) |  |
| [`declinesUpFront(float $sampleRate, RandomnessInterface $randomness, bool &$rolled): bool`](#declinesupfront) | Whether this policy can already tell, at request entry, that nothing will be kept. |
| [`from(string|int $value): static`](#from) |  |
| [`fromConfigValue(string $value): SamplingPolicy`](#fromconfigvalue) | Resolves `replay.record`'s configured string to a policy. |
| [`shouldKeep(int $status, bool $exceptionEscaped, float $sampleRate, RandomnessInterface $randomness, bool $headerPresent, ?bool $rolled = null): bool`](#shouldkeep) | Whether a request with the given outcome should be kept, under this policy. |
| [`tryFrom(string|int $value): ?static`](#tryfrom) |  |

### cases()

`public static function cases(): array`

Returns `array`

### declinesUpFront()

`public function declinesUpFront(float $sampleRate, RandomnessInterface $randomness, bool &$rolled): bool`

Whether this policy can already tell, at request entry, that nothing will be kept.

Only `Rate` can: its decision is a coin flip that does not depend on the outcome, so losing the flip up front means the whole capture -- the body copy, the upload digests, the effect ledger -- can be skipped rather than performed and thrown away. `Error` and `Header` genuinely need the response, and `Always`/`Never` are already decided.

The roll is passed in rather than taken here so `process()` makes it exactly once: rolling again in `shouldKeep()` would sample twice at the configured rate and keep far fewer requests than asked for.

| Parameter | Type | Description |
|---|---|---|
| `$sampleRate` | `float` |  |
| `$randomness` | [`RandomnessInterface`](/api/support/random/randomness-interface/) |  |
| `$rolled` | `bool` |  |

Returns `bool`

### from()

`public static function from(string|int $value): static`

| Parameter | Type | Description |
|---|---|---|
| `$value` | `string``|``int` |  |

Returns `static`

### fromConfigValue()

`public static function fromConfigValue(string $value): SamplingPolicy`

Resolves `replay.record`'s configured string to a policy.

An unrecognised value throws rather than silently falling back to `never` -- the same rule `ratelimit.storage` follows, and for the same reason: a typo must not silently enable or disable a security-relevant feature.

| Parameter | Type | Description |
|---|---|---|
| `$value` | `string` |  |

Returns [`SamplingPolicy`](/api/replay/recording/sampling-policy/)

### shouldKeep()

`public function shouldKeep(int $status, bool $exceptionEscaped, float $sampleRate, RandomnessInterface $randomness, bool $headerPresent, ?bool $rolled = null): bool`

Whether a request with the given outcome should be kept, under this policy.

`$status`/`$exceptionEscaped` are only meaningful for `Error`, and `$sampleRate`/`$randomness` only for `Rate`, and `$headerPresent` only for `Header` -- each policy reads only the parameters it needs and ignores the rest.

| Parameter | Type | Description |
|---|---|---|
| `$status` | `int` |  |
| `$exceptionEscaped` | `bool` |  |
| `$sampleRate` | `float` |  |
| `$randomness` | [`RandomnessInterface`](/api/support/random/randomness-interface/) |  |
| `$headerPresent` | `bool` |  |
| `$rolled` | `?``bool` |  |

Returns `bool`

### tryFrom()

`public static function tryFrom(string|int $value): ?static`

| Parameter | Type | Description |
|---|---|---|
| `$value` | `string``|``int` |  |

Returns `?``static`
