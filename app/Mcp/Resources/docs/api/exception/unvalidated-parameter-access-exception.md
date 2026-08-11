# UnvalidatedParameterAccessException

> Raised by WebRequest::getParameter() when a parameter that no validator declared is read without a default.

Raised by [`WebRequest::getParameter()`](/api/request/web-request/#getparameter) when a parameter that no validator declared is read without a default.

`ValidationMiddleware` prunes the request down to the parameters the action's validators declared, and only those — plus anything application code set with `setParameter()` — are whitelisted afterwards. An action with no validators at all therefore has an empty whitelist: nothing was vetted, so nothing is readable. Reading raw input from a middleware ordered before `ValidationMiddleware` sees values that disappear by the time the action runs, which is the usual reason this surfaces.

Passing a default (`getParameter('foo', null)`) returns that default instead of throwing; it never returns the unvalidated value.

## Synopsis

`class UnvalidatedParameterAccessException extends QuioteException`

|  |  |
|---|---|
| Extends | [`QuioteException`](/api/exception/quiote-exception/) |
| Source | `Exception/UnvalidatedParameterAccessException.php` |

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `getCode()` | `Exception` |  |
| `getFile()` | `Exception` |  |
| `getLine()` | `Exception` |  |
| `getMessage()` | `Exception` |  |
| `getOriginalCode()` | [`QuioteException`](/api/exception/quiote-exception/) | Returns the original code, which may be a string (e.g. |
| `getPrevious()` | `Exception` |  |
| `getTrace()` | `Exception` |  |
| `getTraceAsString()` | `Exception` |  |
