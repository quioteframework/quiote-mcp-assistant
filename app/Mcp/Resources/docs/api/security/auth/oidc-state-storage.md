# OidcStateStorage

> Persists a single in-flight OidcAuthorizationState in the session-backed `Context` storage, keyed by its own `state` value so a concurrent second login attempt in another tab doesn't clobber the first.

Persists a single in-flight [`OidcAuthorizationState`](/api/security/auth/oidc-authorization-state/) in the session-backed `Context` storage, keyed by its own `state` value so a concurrent second login attempt in another tab doesn't clobber the first.

[`OidcStateStorage::consume()`](/api/security/auth/oidc-state-storage/#consume) removes the entry on read.

Single-use is enforced per request, not atomically. The removal in [`OidcStateStorage::consume()`](/api/security/auth/oidc-state-storage/#consume) lands in the in-memory session bag and only becomes durable when the session is persisted at the end of the request, and nothing locks the session across that read-modify-write. Two callbacks carrying the same `state` that are genuinely in flight at the same moment can therefore both load the session row, both observe the entry and both proceed; the later persist wins.

That gap is left open deliberately rather than papered over. Closing it needs either session-level locking -- which [`SessionPersistenceInterface`](/api/session/session-persistence-interface/) has no concept of (no lock/unlock, no compare-and-swap) and which several of the shipped backends could not implement at all, object stores in particular -- or moving OIDC state out of the session onto its own store with an atomic compare-and-delete. Both are larger changes than the residual risk justifies:

- PKCE already binds the code exchange to a verifier the attacker does not hold, so a replayed `state` alone does not yield tokens. - The authorization server is required to reject a reused authorization code, which is the actual single-use guarantee for the credential that matters. - Winning the race additionally requires already possessing a valid code.

So treat this as defence in depth with a known bound, not as an atomic one-shot. If an application's threat model needs the stronger property, supply a storage implementation with a real atomic take operation.

## Synopsis

`final class OidcStateStorage`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `OidcStateStorage.php` |

## Constructor

### __construct()

`public function __construct(Context $context): mixed`

The current application context, used to reach its session.

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) | The current application context, used to reach its session. |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`consume(string $state): ?OidcAuthorizationState`](#consume) | Retrieve and remove the stored state for $state, or null if none exists (already consumed, expired session, or forged value). |
| [`store(OidcAuthorizationState $state): void`](#store) |  |

### consume()

`public function consume(string $state): ?OidcAuthorizationState`

Retrieve and remove the stored state for $state, or null if none exists (already consumed, expired session, or forged value).

The `state` value received on the callback.

| Parameter | Type | Description |
|---|---|---|
| `$state` | `string` | The `state` value received on the callback. |

Returns `?`[`OidcAuthorizationState`](/api/security/auth/oidc-authorization-state/) — The stored state, or null if none exists for $state.

### store()

`public function store(OidcAuthorizationState $state): void`

The state to persist, keyed by its own `state` value.

| Parameter | Type | Description |
|---|---|---|
| `$state` | [`OidcAuthorizationState`](/api/security/auth/oidc-authorization-state/) | The state to persist, keyed by its own `state` value. |
