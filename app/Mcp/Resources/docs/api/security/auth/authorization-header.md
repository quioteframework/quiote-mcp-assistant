# AuthorizationHeader

> Parses an `Authorization` header into its scheme and credential, the way RFC 9110 §11.6.2 actually specifies it rather than the way the wire format usually looks.

Parses an `Authorization` header into its scheme and credential, the way RFC 9110 §11.6.2 actually specifies it rather than the way the wire format usually looks.

Two things every authenticator got wrong when doing this itself:

- **The scheme is case-insensitive.** Comparing it with `str_starts_with($h, 'Bearer ')` rejects the legal `bearer eyJ...` that some clients and proxies emit. The request then carries no supported credential, falls through as unauthenticated, and surfaces as a login forward rather than the 401 the entry point exists to produce -- the same confusion the "bare Bearer" note in [`BearerTokenAuthenticator`](/api/security/auth/bearer-token-authenticator/) already warns about, one step out. - **The separator is a run of whitespace, not one space.** `substr($h, strlen('Bearer '))` on `Bearer  token` yields a credential with a leading space, which then fails signature verification (or base64 decoding) with an error that says nothing about the real cause.

A declared scheme with an empty credential returns `''`, not null: the caller did declare the scheme, so it must be answered with a 401 challenge rather than treated as "no credential presented".

## Synopsis

`final class AuthorizationHeader`

|  |  |
|---|---|
| Since | `3.0.3` |
| Source | `Security/Auth/AuthorizationHeader.php` |

## Methods

| Method | Description |
|---|---|
| [`credential(ServerRequestInterface $request, string $scheme): ?string`](#credential) | The credential following $scheme in $request's `Authorization` header. |
| [`declares(ServerRequestInterface $request, string $scheme): bool`](#declares) | Whether $request declares $scheme at all, regardless of whether it supplied a credential with it. |

### credential()

`public static function credential(ServerRequestInterface $request, string $scheme): ?string`

The credential following $scheme in $request's `Authorization` header.

The expected auth scheme, e.g. `Bearer` or `Basic`. Matched case-insensitively.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) | The incoming request. |
| `$scheme` | `string` | The expected auth scheme, e.g. `Bearer` or `Basic`. Matched case-insensitively. |

Returns `?``string` — The credential (possibly `''` when the scheme was declared without one), or null when the header is absent or declares a different scheme.

### declares()

`public static function declares(ServerRequestInterface $request, string $scheme): bool`

Whether $request declares $scheme at all, regardless of whether it supplied a credential with it.

The expected auth scheme. Matched case-insensitively.

| Parameter | Type | Description |
|---|---|---|
| `$request` | [`ServerRequestInterface`](https://www.php-fig.org/psr/psr-7/) | The incoming request. |
| `$scheme` | `string` | The expected auth scheme. Matched case-insensitively. |

Returns `bool` — True if the header declares $scheme, otherwise false.
