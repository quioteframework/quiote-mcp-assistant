# Session

> The Quiote\\Session namespace — 19 documented types.

Everything under `Quiote\Session`.

## Classes

| Class | Description |
|---|---|
| [`FileSessionFactory`](/api/session/file-session-factory/) | The default `session` slot factory: file-backed, zero dependencies, no database required. |
| [`FileSessionPersistence`](/api/session/file-session-persistence/) | File-backed SessionPersistenceInterface implementation — the zero-dependency default backend. |
| [`NullSessionBag`](/api/session/null-session-bag/) | A [`SessionBagInterface`](/api/session/session-bag-interface/) that stores nothing. |
| [`ObjectStoreSessionPersistence`](/api/session/object-store-session-persistence/) | A [`SessionPersistenceInterface`](/api/session/session-persistence-interface/) storing one object per session id in any [`ObjectStoreClientInterface`](/api/storage/object-store-client-interface/). |
| [`PdoSessionFactory`](/api/session/pdo-session-factory/) | `session` slot factory for [`PdoSessionPersistence`](/api/session/pdo-session-persistence/), taking its connection from the application's own database manager so sessions live alongside everything else rather than needing separate credentials. |
| [`PdoSessionPersistence`](/api/session/pdo-session-persistence/) | Default PDO-backed SessionPersistenceInterface implementation. |
| [`QuioteSessionBag`](/api/session/quiote-session-bag/) | [`SessionBagInterface`](/api/session/session-bag-interface/) over the PSR-7-native [`SessionManager`](/api/session/session-manager/) stack. |
| [`Session`](/api/session/session/) | Mutable session handle. |
| [`SessionCodec`](/api/session/session-codec/) | The shipped session codec: igbinary when it is available and wanted, JSON otherwise, and reads both regardless of which it writes. |
| [`SessionManager`](/api/session/session-manager/) | Opinionated, PSR-7-based session handling: a cookie carrying a session id, and a pluggable SessionPersistenceInterface backend for the data. |
| [`SessionMiddleware`](/api/session/session-middleware/) | Opt-in PSR-15 middleware wiring SessionManager into the request lifecycle: loads/creates the session before the handler runs and attaches it to the request as an attribute keyed by self::class, then persists + bakes the Set-Cookie header onto the response afterwards. |

## Interfaces

| Interface | Description |
|---|---|
| [`SessionBagInterface`](/api/session/session-bag-interface/) | The narrow per-session key/value contract everything that needs session state talks to: the User hierarchy, CSRF token storage, OIDC state, and application code. |
| [`SessionCodecInterface`](/api/session/session-codec-interface/) | Serializes a session payload for storage, and reads it back. |
| [`SessionFactoryInterface`](/api/session/session-factory-interface/) | Builds the persistence backend for the `session` factory slot. |
| [`SessionPersistenceInterface`](/api/session/session-persistence-interface/) | Storage backend contract for SessionManager. |

## Nested namespaces

| Namespace | Contents |
|---|---|
| [`Pdo`](/api/session/pdo/) | 2 types |
| [`Redis`](/api/session/redis/) | 2 types |
