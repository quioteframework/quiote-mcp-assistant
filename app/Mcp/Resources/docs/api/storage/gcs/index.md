# Gcs

> The Quiote\\Storage\\Gcs namespace — 4 documented types.

Everything under `Quiote\Storage\Gcs`.

## Classes

| Class | Description |
|---|---|
| [`GcsClient`](/api/storage/gcs/gcs-client/) | Minimal Google Cloud Storage REST client authenticating with an HMAC key pair (GCS's "interoperability" auth mode, meant for exactly this kind of S3-like tool) rather than a service-account OAuth2/JWT flow — no `google/cloud-storage` dependency, no token exchange round-trip, just the operations a session or filesystem backend needs against the XML API: get, put, delete and head a single object. |
| [`GcsSessionFactory`](/api/storage/gcs/gcs-session-factory/) | `session` slot factory for [`GcsSessionPersistence`](/api/storage/gcs/gcs-session-persistence/). |
| [`GcsSessionPersistence`](/api/storage/gcs/gcs-session-persistence/) | [`SessionPersistenceInterface`](/api/session/session-persistence-interface/) storing one JSON object per session id (object `<prefix><sid>.json`) in a single GCS bucket. |
| [`GcsStorageException`](/api/storage/gcs/gcs-storage-exception/) | A failure talking to GCS storage. |
