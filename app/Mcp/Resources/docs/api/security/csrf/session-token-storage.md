# SessionTokenStorage

> Symfony CSRF TokenStorage backed by Quiote's session.

Symfony CSRF TokenStorage backed by Quiote's session.

Lets symfony/security-csrf persist its per-session tokens through whichever session backend the context is configured with, instead of the component's own NativeSessionTokenStorage, so CSRF state lives in the same session as the rest of the application -- notably the same one the User hierarchy uses.

## Synopsis

`final readonly class SessionTokenStorage implements TokenStorageInterface`

|  |  |
|---|---|
| Implements | `TokenStorageInterface` |
| Source | `SessionTokenStorage.php` |

## Constructor

### __construct()

`public function __construct(Context $context): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`getToken(string $tokenId): string`](#gettoken) | Returns the stored token for the given id. |
| [`hasToken(string $tokenId): bool`](#hastoken) | Whether a token is currently stored in the session for the given id. |
| [`removeToken(string $tokenId): ?string`](#removetoken) | Removes the token for the given id and returns the value that was held. |
| [`setToken(string $tokenId, string $token): void`](#settoken) | Stores the token for the given id in the session bag, replacing any value already held under that id. |

### getToken()

`public function getToken(string $tokenId): string`

Returns the stored token for the given id.

The value is read from the session bag under this class's namespace prefix. A missing entry, and equally one that is empty or not a string, counts as no token at all and raises `TokenNotFoundException`, as the Symfony storage contract requires.

| Parameter | Type | Description |
|---|---|---|
| `$tokenId` | `string` |  |

Returns `string`

| Throws | When |
|---|---|
| `TokenNotFoundException` | if no usable token is stored for the id. |

### hasToken()

`public function hasToken(string $tokenId): bool`

Whether a token is currently stored in the session for the given id.

| Parameter | Type | Description |
|---|---|---|
| `$tokenId` | `string` |  |

Returns `bool`

### removeToken()

`public function removeToken(string $tokenId): ?string`

Removes the token for the given id and returns the value that was held.

Returns null when nothing was stored, or when what was stored was not a string; the session entry is removed either way.

| Parameter | Type | Description |
|---|---|---|
| `$tokenId` | `string` |  |

Returns `?``string`

### setToken()

`public function setToken(string $tokenId, string $token): void`

Stores the token for the given id in the session bag, replacing any value already held under that id.

| Parameter | Type | Description |
|---|---|---|
| `$tokenId` | `string` |  |
| `$token` | `string` |  |
