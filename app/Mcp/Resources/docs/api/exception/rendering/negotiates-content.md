# NegotiatesContent

> Shared Accept-header negotiation for exception renderers.

Shared Accept-header negotiation for exception renderers.

Deliberately does NOT read the `output_type` request attribute that ContentNegotiationMiddleware sets: ErrorHandlingMiddleware sits outermost in the pipeline and renders using the request it originally received, not whatever downstream middleware produced via withAttribute() before throwing -- PSR-7 immutability means those mutations never propagate back up to the catch site. The `Accept` header is present on the original request unconditionally, so it's what both renderers negotiate on.

## Synopsis

`trait NegotiatesContent`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Exception/Rendering/NegotiatesContent.php` |
