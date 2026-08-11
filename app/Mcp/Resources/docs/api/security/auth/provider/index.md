# Provider

> The Quiote\\Security\\Auth\\Provider namespace — 3 documented types.

Everything under `Quiote\Security\Auth\Provider`.

## Classes

| Class | Description |
|---|---|
| [`CallableUserProvider`](/api/security/auth/provider/callable-user-provider/) | Delegates identity/claim resolution to app-supplied callables, for lookups that don't fit `InMemoryUserProvider`'s static list or `PdoUserProvider`'s single-table convention (e.g. |
| [`InMemoryUserProvider`](/api/security/auth/provider/in-memory-user-provider/) | A config-driven `UserProviderInterface`, for apps with a small, static user list (the `security.xml` `<provider type="in_memory">` shape). |
| [`PdoUserProvider`](/api/security/auth/provider/pdo-user-provider/) | Resolves identities from a single users table via the framework's `DatabaseManager`, matching the `security.xml` `<provider type="pdo" connection="main" table="users" identifier-column="email" password-column="password_hash">` shape. |
