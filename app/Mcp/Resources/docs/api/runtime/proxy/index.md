# Proxy

> The Quiote\\Runtime\\Proxy namespace — 2 documented types.

Everything under `Quiote\Runtime\Proxy`.

## Classes

| Class | Description |
|---|---|
| [`ForwardedAuthority`](/api/runtime/proxy/forwarded-authority/) | The scheme/host/port a reverse proxy says the client actually used, as resolved by [`ForwardedHeaderResolver`](/api/runtime/proxy/forwarded-header-resolver/). |
| [`ForwardedHeaderResolver`](/api/runtime/proxy/forwarded-header-resolver/) | Reads the reverse-proxy headers off a PSR-7 request and reports the scheme/host/port the client actually used. |
