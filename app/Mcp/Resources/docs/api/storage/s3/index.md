# S3

> The Quiote\\Storage\\S3 namespace — 4 documented types.

Everything under `Quiote\Storage\S3`.

## Classes

| Class | Description |
|---|---|
| [`S3Client`](/api/storage/s3/s3-client/) | Minimal S3 REST client using AWS Signature Version 4, deliberately not built on `aws/aws-sdk-php` (a heavy dependency pulling in a client for every AWS service) for the operations a session or filesystem backend needs: get, put, delete, head and list. |
| [`S3SessionFactory`](/api/storage/s3/s3-session-factory/) | `session` slot factory for [`S3SessionPersistence`](/api/storage/s3/s3-session-persistence/). |
| [`S3SessionPersistence`](/api/storage/s3/s3-session-persistence/) | [`SessionPersistenceInterface`](/api/session/session-persistence-interface/) storing one JSON object per session id (key `<prefix><sid>.json`) in a single S3 bucket. |
| [`S3StorageException`](/api/storage/s3/s3-storage-exception/) | A failure talking to S3 storage. |
