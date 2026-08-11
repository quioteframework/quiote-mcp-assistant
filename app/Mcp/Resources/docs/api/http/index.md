# Http

> The Quiote\\Http namespace — 21 documented types.

Everything under `Quiote\Http`.

## Classes

| Class | Description |
|---|---|
| [`CookieSerializer`](/api/http/cookie-serializer/) | Bridges cookies queued on a Quiote response onto a PSR-7 response's `Set-Cookie` headers. |
| [`HttpStatus`](/api/http/http-status/) | The single source of truth for HTTP status-code validity and reason phrases. |
| [`MimeTypeRegistry`](/api/http/mime-type-registry/) | Maps between Quiote format names, MIME types, and file extensions using symfony/mime. |
| [`ProblemDetails`](/api/http/problem-details/) | An RFC 9457 (Problem Details for HTTP APIs; obsoletes RFC 7807) document. |
| [`Psr17`](/api/http/psr17/) | Shared stateless Nyholm\Psr7\Factory\Psr17Factory instance. |
| [`PsrResponseAdapter`](/api/http/psr-response-adapter/) | A PSR-7 view of a [`WebResponse`](/api/response/web-response/), so a view or action handed a PSR-7 response can read the status, headers and body the framework has assembled. |
| [`PsrServerRequestAdapter`](/api/http/psr-server-request-adapter/) | DEPRECATED: PsrServerRequestAdapter has been removed in favor of using WebRequest directly (which now implements ServerRequestInterface). |
| [`RequestScheme`](/api/http/request-scheme/) | Whether a PSR-7 request reached the client over TLS. |
| [`SimpleStream`](/api/http/simple-stream/) | A minimal PSR-7 `StreamInterface` over a plain PHP stream resource, so the framework can produce response bodies without depending on a third-party PSR-7 implementation. |
| [`SimpleUri`](/api/http/simple-uri/) | A minimal PSR-7 `UriInterface` built by handing a URI string to `parse_url()`, so the framework can supply a URI without depending on a third-party PSR-7 implementation. |

## Nested namespaces

| Namespace | Contents |
|---|---|
| [`Client`](/api/http/client/) | 8 types |
| [`Sse`](/api/http/sse/) | 3 types |
