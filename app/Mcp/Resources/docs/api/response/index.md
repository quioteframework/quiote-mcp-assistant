# Response

> The Quiote\\Response namespace — 4 documented types.

Everything under `Quiote\Response`.

## Classes

| Class | Description |
|---|---|
| [`CookieSerializer`](/api/response/cookie-serializer/) | Turns the cookie definitions queued on a response into `Set-Cookie` header lines. |
| [`PsrResponseBuilder`](/api/response/psr-response-builder/) | Assembles a PSR-7 response from already-resolved status, headers, cookies and body. |
| [`WebResponse`](/api/response/web-response/) | WebResponse handles the HTTP response: status code, headers, cookies, redirects and the content sent back to the client. |

## Interfaces

| Interface | Description |
|---|---|
| [`WebResponseInterface`](/api/response/web-response-interface/) | The response an action or view writes to: body, status, headers, cookies, redirect and content type, plus the conversion to PSR-7 the runtime emits. |
