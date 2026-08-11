# HttpMethodMapper

> Central mapping from HTTP verbs to Quiote action method tokens.

Central mapping from HTTP verbs to Quiote action method tokens.

Canonical values are lowercase: read, write, update, remove. This is the single source of truth — ActionResolver derives its execute<Token>() dispatch from this same mapping so the two never diverge.

The default mapping can be extended or overridden via the `routing.http_method_map` setting. A bare <settings> block always lands under the `core.` prefix, so setting `routing.http_method_map` needs a `prefix` attribute on the wrapping <settings> element (settings.xml): <settings prefix="routing."> <setting name="http_method_map"> <ae:parameter name="PATCH">write</ae:parameter> <ae:parameter name="LOCK">lock</ae:parameter> </setting> </settings> or programmatically: Config::set('routing.http_method_map', ['LOCK' => 'lock']). Keys are matched case-insensitively; values become the `execute<Token>()` method name on the action (ucfirst-ed), so a custom token like 'lock' needs a matching executeLock() method on any action that should handle it.

## Synopsis

`final class HttpMethodMapper`

|  |  |
|---|---|
| Source | `Execution/HttpMethodMapper.php` |

## Methods

| Method | Description |
|---|---|
| [`toActionMethod(string $verb): string`](#toactionmethod) | Maps an HTTP verb to the action method token that handles it. |

### toActionMethod()

`public static function toActionMethod(string $verb): string`

Maps an HTTP verb to the action method token that handles it.

The verb is matched case-insensitively against the default map merged with any `routing.http_method_map` overrides. An unknown verb yields `read`, so an action never fails to dispatch merely because a verb is unmapped. The token is ucfirst-ed by the resolver into the `execute<Token>()` method name.

| Parameter | Type | Description |
|---|---|---|
| `$verb` | `string` |  |

Returns `string`
