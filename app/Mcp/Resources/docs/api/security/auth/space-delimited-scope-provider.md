# SpaceDelimitedScopeProvider

> `league/oauth2-client`'s `AbstractProvider::getScopeSeparator()` returns a comma and `GenericProvider` does not override it, so a multi-scope authorization request comes out as `scope=openid%2Cprofile%2Cemail`.

`league/oauth2-client`'s `AbstractProvider::getScopeSeparator()` returns a comma and `GenericProvider` does not override it, so a multi-scope authorization request comes out as `scope=openid%2Cprofile%2Cemail`.

RFC 6749 §3.3 defines `scope` as a space-delimited list, and real authorization servers (Google, Microsoft Entra ID, Okta) either reject the comma form or parse it as a single unknown scope. The failure surfaces at the provider's authorize endpoint, after the redirect has left this app — about the worst place to debug it — so the separator is corrected here rather than left to each caller to pre-join.

## Synopsis

`final class SpaceDelimitedScopeProvider extends GenericProvider`

|  |  |
|---|---|
| Extends | `GenericProvider` |
| Since | `3.0.2` |
| Source | `SpaceDelimitedScopeProvider.php` |

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `authorize()` | `AbstractProvider` | Redirects the client for authorization. |
| `getAccessToken()` | `AbstractProvider` | Requests an access token using a specified grant and option set. |
| `getAuthenticatedRequest()` | `AbstractProvider` | Returns an authenticated PSR-7 request instance. |
| `getAuthorizationUrl()` | `AbstractProvider` | Builds the authorization URL. |
| `getBaseAccessTokenUrl()` | `GenericProvider` |  |
| `getBaseAuthorizationUrl()` | `GenericProvider` |  |
| `getDefaultScopes()` | `GenericProvider` |  |
| `getGrantFactory()` | `AbstractProvider` | Returns the current grant factory instance. |
| `getGuarded()` | `AbstractProvider` | Returns current guarded properties. |
| `getHeaders()` | `AbstractProvider` | Returns all headers used by this provider for a request. |
| `getHttpClient()` | `AbstractProvider` | Returns the HTTP client instance. |
| `getOptionProvider()` | `AbstractProvider` | Returns the option provider instance. |
| `getParsedResponse()` | `AbstractProvider` | Sends a request and returns the parsed response. |
| `getPkceCode()` | `AbstractProvider` | Returns the current value of the pkceCode parameter. |
| `getRequest()` | `AbstractProvider` | Returns a PSR-7 request instance that is not authenticated. |
| `getRequestFactory()` | `AbstractProvider` | Returns the request factory instance. |
| `getResourceOwner()` | `AbstractProvider` | Requests and returns the resource owner of given access token. |
| `getResourceOwnerDetailsUrl()` | `GenericProvider` |  |
| `getResponse()` | `AbstractProvider` | Sends a request instance and returns a response instance. |
| `getState()` | `AbstractProvider` | Returns the current value of the state parameter. |
| `isGuarded()` | `AbstractProvider` | Determines if the given property is guarded. |
| `setGrantFactory()` | `AbstractProvider` | Sets the grant factory instance. |
| `setHttpClient()` | `AbstractProvider` | Sets the HTTP client instance. |
| `setOptionProvider()` | `AbstractProvider` | Sets the option provider instance. |
| `setPkceCode()` | `AbstractProvider` | Set the value of the pkceCode parameter. |
| `setRequestFactory()` | `AbstractProvider` | Sets the request factory instance. |
