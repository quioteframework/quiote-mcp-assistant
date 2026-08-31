# Cassette

> The full record of one request.

The full record of one request.

`meta`, `request` and `response` are the only sections a cassette must carry; every other section is optional and empty/null when not captured, so a minimal cassette stays small.

A plain value object rather than one with sub-value-objects per section: [`CassetteCodec`](/api/replay/cassette/cassette-codec/) is the only reader/writer, and splitting `request`/`response`/`resolved` into their own classes would add indirection with no consumer that needs it yet.

## Synopsis

`final readonly class Cassette`

|  |  |
|---|---|
| Source | `Cassette/Cassette.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$effects` | `array` | _readonly._ |
| `$exception` | `?``array` | _readonly._ |
| `$log` | `?``array` | _readonly._ |
| `$meta` | `array` | _readonly._ |
| `$request` | `array` | _readonly._ |
| `$resolved` | `array` | _readonly._ |
| `$response` | `array` | _readonly._ |
| `$schemaVersion` | `int` | _readonly._ |
| `$session` | `?``array` | _readonly._ |
| `$user` | `?``array` | _readonly._ |

## Constructor

### __construct()

`public function __construct(non-negative-int $schemaVersion, array<string, mixed> $meta, array<string, mixed> $request, array<string, mixed> $resolved, array<string, mixed>|null $session, array<string, mixed>|null $user, list<Effect> $effects, array<string, mixed> $response, array<string, mixed>|null $exception, list<mixed>|null $log): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$schemaVersion` | `non-negative-int` |  |
| `$meta` | `array``<``string``, ``mixed``>` | {id, recorded_at, quiote_version, php_version, context, source_hash, runtime, trace_id, span_id, trigger} |
| `$request` | `array``<``string``, ``mixed``>` | {method, uri, protocol, headers, cookies, body, uploads, server} |
| `$resolved` | `array``<``string``, ``mixed``>` | {route, module, action, route_params, output_type, validated_params, validation_report} |
| `$session` | `array``<``string``, ``mixed``>``|``null` | {before, after, id_rotated} |
| `$user` | `array``<``string``, ``mixed``>``|``null` | {authenticated, identity, roles} |
| `$effects` | `list``<`[`Effect`](/api/replay/cassette/effect/)`>` |  |
| `$response` | `array``<``string``, ``mixed``>` | {status, headers, body, stray_output} |
| `$exception` | `array``<``string``, ``mixed``>``|``null` | {class, message, file, line, trace} |
| `$log` | `list``<``mixed``>``|``null` |  |

Returns `mixed`
