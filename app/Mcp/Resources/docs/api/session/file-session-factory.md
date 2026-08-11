# FileSessionFactory

> The default `session` slot factory: file-backed, zero dependencies, no database required.

The default `session` slot factory: file-backed, zero dependencies, no database required.

Suitable for a single host or any deployment with a shared filesystem; for multiple hosts without one, configure a PDO, Redis or object-storage backed factory instead.

Parameters: `dir` (defaults to `core.app_dir`/cache/sessions), plus whatever [`FileSessionPersistence`](/api/session/file-session-persistence/) accepts (`idle_ttl`, `gc_probability`, `gc_divisor`).

## Synopsis

`final class FileSessionFactory implements SessionFactoryInterface`

|  |  |
|---|---|
| Implements | [`SessionFactoryInterface`](/api/session/session-factory-interface/) |
| Since | `2.2.0` |
| Source | `Session/FileSessionFactory.php` |

## Methods

| Method | Description |
|---|---|
| [`createPersistence(Context $context, array $parameters): SessionPersistenceInterface`](#createpersistence) | Builds a [`FileSessionPersistence`](/api/session/file-session-persistence/) over the configured directory. |

### createPersistence()

`public function createPersistence(Context $context, array $parameters): SessionPersistenceInterface`

Builds a [`FileSessionPersistence`](/api/session/file-session-persistence/) over the configured directory.

A missing or non-string `dir` parameter falls back to `core.app_dir`/cache/sessions, and `core.app_dir` in turn to the system temp directory. The remaining parameters are passed through untouched.

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) |  |
| `$parameters` | `array` |  |

Returns [`SessionPersistenceInterface`](/api/session/session-persistence-interface/)

| Throws | When |
|---|---|
| `StorageException` | if the directory cannot be created or is not writable. |
