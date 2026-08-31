# RandomnessBackedTokenGenerator

> A drop-in replacement for Symfony's default UriSafeTokenGenerator, generating the same URI-safe base64 shape but through RandomnessInterface instead of a direct `random_bytes()` call -- so a cassette that records the RandomnessInterface reads behind a CSRF token can reproduce that exact token value on replay, and a request whose form POST depends on it does not fail the CSRF check purely because the token could not be regenerated deterministically.

A drop-in replacement for Symfony's default `UriSafeTokenGenerator`, generating the same URI-safe base64 shape but through [`RandomnessInterface`](/api/support/random/randomness-interface/) instead of a direct `random_bytes()` call -- so a cassette that records the [`RandomnessInterface`](/api/support/random/randomness-interface/) reads behind a CSRF token can reproduce that exact token value on replay, and a request whose form POST depends on it does not fail the CSRF check purely because the token could not be regenerated deterministically.

## Synopsis

`final class RandomnessBackedTokenGenerator implements TokenGeneratorInterface`

|  |  |
|---|---|
| Implements | `TokenGeneratorInterface` |
| Source | `RandomnessBackedTokenGenerator.php` |

## Constructor

### __construct()

`public function __construct(RandomnessInterface $randomness = new SystemRandomness(…), int $entropy = 256): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$randomness` | [`RandomnessInterface`](/api/support/random/randomness-interface/) |  |
| `$entropy` | `int` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`generateToken(): string`](#generatetoken) | Generates a CSRF token. |

### generateToken()

`public function generateToken(): string`

Generates a CSRF token.

Returns `string`
