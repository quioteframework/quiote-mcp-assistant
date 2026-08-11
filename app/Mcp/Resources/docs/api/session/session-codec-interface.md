# SessionCodecInterface

> Serializes a session payload for storage, and reads it back.

Serializes a session payload for storage, and reads it back.

A session's stored form is a wire format: whatever writes it has to agree with whatever reads it, including a different backend reading a payload another one wrote, and a build with different extensions available. That agreement is this interface's whole purpose -- a [`SessionPersistenceInterface`](/api/session/session-persistence-interface/) implementation decides *where* a payload goes and delegates *what it looks like* here.

Implement this to change the stored form -- encryption at rest, a compressed envelope, a format an external consumer already reads -- and hand it to the persistence backend.

## Synopsis

`interface SessionCodecInterface`

|  |  |
|---|---|
| Implemented by | [`SessionCodec`](/api/session/session-codec/) |
| Since | `3.2.0` |
| Source | `Session/SessionCodecInterface.php` |

## Methods

| Method | Description |
|---|---|
| [`decode(string $payload): array<string, mixed>|null`](#decode) | Decode a stored payload, or null when it does not hold readable session data. |
| [`encode(array<string, mixed> $data): string`](#encode) | Encode session data for storage. |

### decode()

`abstract public function decode(string $payload): array<string, mixed>|null`

Decode a stored payload, or null when it does not hold readable session data.

Null rather than an exception for unreadable input: a payload written by an older format, a truncated row, or a value that decodes to something that is not a session are all reasons to treat the session as absent and start a new one, not to fail the request.

| Parameter | Type | Description |
|---|---|---|
| `$payload` | `string` |  |

Returns `array``<``string``, ``mixed``>``|``null`

### encode()

`abstract public function encode(array<string, mixed> $data): string`

Encode session data for storage.

| Parameter | Type | Description |
|---|---|---|
| `$data` | `array``<``string``, ``mixed``>` |  |

Returns `string`

| Throws | When |
|---|---|
| `StorageException` | If the data cannot be encoded at all. |
