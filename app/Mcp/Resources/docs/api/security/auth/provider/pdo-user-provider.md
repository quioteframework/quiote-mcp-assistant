# PdoUserProvider

> Resolves identities from a single users table via the framework's `DatabaseManager`, matching the `security.xml` `<provider type=\"pdo\" connection=\"main\" table=\"users\" identifier-column=\"email\" password-column=\"password_hash\">` shape.

Resolves identities from a single users table via the framework's `DatabaseManager`, matching the `security.xml` `<provider type="pdo" connection="main" table="users" identifier-column="email" password-column="password_hash">` shape.

Role/permission assignment is left to `RbacSecurityUser`'s own definitions, not this table.

## Synopsis

`final class PdoUserProvider implements UserProviderInterface`

|  |  |
|---|---|
| Implements | [`UserProviderInterface`](/api/security/auth/user-provider-interface/) |
| Since | `1.0.0` |
| Source | `Provider/PdoUserProvider.php` |

## Constructor

### __construct()

`public function __construct(DatabaseManager $databaseManager, string $connection = 'main', string $table = 'users', string $identifierColumn = 'email', string $passwordColumn = 'password_hash'): mixed`

The column holding the password hash.

| Parameter | Type | Description |
|---|---|---|
| `$databaseManager` | [`DatabaseManager`](/api/database/database-manager/) | The framework's database manager. |
| `$connection` | `string` | The `databases.xml` connection name to use. |
| `$table` | `string` | The users table name. |
| `$identifierColumn` | `string` | The column holding the stable identifier (e.g. email/username). |
| `$passwordColumn` | `string` | The column holding the password hash. |

Returns `mixed`

| Throws | When |
|---|---|
| `InvalidArgumentException` | If $table/$identifierColumn/$passwordColumn is not a valid SQL identifier. |

## Methods

| Method | Description |
|---|---|
| [`loadByIdentifier(string $identifier): ?UserIdentity`](#loadbyidentifier) |  |
| [`loadByToken(TokenClaims $claims): null`](#loadbytoken) | Claim -> row mapping (e.g. |

### loadByIdentifier()

`public function loadByIdentifier(string $identifier): ?UserIdentity`

E.g. an email or username.

| Parameter | Type | Description |
|---|---|---|
| `$identifier` | `string` | E.g. an email or username. |

Returns `?`[`UserIdentity`](/api/security/auth/user-identity/) — Null if no matching row exists.

| Throws | When |
|---|---|
| `RuntimeException` | If the configured connection is not PDO-backed. |

### loadByToken()

`public function loadByToken(TokenClaims $claims): null`

Claim -> row mapping (e.g.

The validated token claims.

| Parameter | Type | Description |
|---|---|---|
| `$claims` | [`TokenClaims`](/api/security/auth/token-claims/) | The validated token claims. |

Returns `null` — Always null in the base implementation.
