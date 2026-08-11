# GcsSessionFactory

> `session` slot factory for GcsSessionPersistence.

`session` slot factory for [`GcsSessionPersistence`](/api/storage/gcs/gcs-session-persistence/).

```yaml session: class: Quiote\Storage\Gcs\GcsSessionFactory params: bucket: my-app-sessions access_key: '%env(GCS_HMAC_ACCESS_KEY)%' secret_key: '%env(GCS_HMAC_SECRET)%' object_prefix: 'sessions/' ```

Uses GCS's S3-compatible HMAC interoperability API, so the credentials are an HMAC key pair rather than a service-account JSON file. Bring your own PSR-18 client, bound in the container.

## Synopsis

`final class GcsSessionFactory implements SessionFactoryInterface`

|  |  |
|---|---|
| Implements | [`SessionFactoryInterface`](/api/session/session-factory-interface/) |
| Since | `3.0.0` |
| Source | `GcsSessionFactory.php` |

## Methods

| Method | Description |
|---|---|
| [`createPersistence(Context $context, array<string, mixed> $parameters): SessionPersistenceInterface`](#createpersistence) | Builds GCS-backed session persistence from the slot's parameters. |

### createPersistence()

`public function createPersistence(Context $context, array<string, mixed> $parameters): SessionPersistenceInterface`

Builds GCS-backed session persistence from the slot's parameters.

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) |  |
| `$parameters` | `array``<``string``, ``mixed``>` |  |

Returns [`SessionPersistenceInterface`](/api/session/session-persistence-interface/)

| Throws | When |
|---|---|
| `RuntimeException` | If no PSR-18 client is bound in the container. |
