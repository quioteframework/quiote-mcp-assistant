# CurrentUser

> The seam onto the user of the request being served *now*.

The seam onto the user of the request being served *now*.

The user is stable within a request -- it is replaced only at the worker request boundary and by the pre-request deferral, never mid-request -- so an object that lives for one execution can simply inject [`User`](/api/user/user/) or [`ISecurityUser`](/api/user/i-security-user/) and hold it. Actions and views are built per execution, so that is the right thing for them:

```php public function __construct(private readonly SecurityUser $user) {} ```

A singleton cannot do that. It is constructed once and keeps whatever it was handed, so the user it captured on request 1 would be served to every later request in a persistent worker -- a cross-user identity leak, which is why the container refuses that wiring outright.

This is what a singleton injects instead. It resolves through to the context on every call and deliberately memoizes nothing: memoizing here would reintroduce exactly the leak the container's captive-dependency guard cannot see past, because injecting this class is legal.

## Synopsis

`final class CurrentUser`

|  |  |
|---|---|
| Since | `4.0.0` |
| Source | `User/CurrentUser.php` |

## Constructor

### __construct()

`public function __construct(Context $context): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`get(): User|ISecurityUser`](#get) | The user as of this call. |
| [`isAuthenticated(): bool`](#isauthenticated) | Whether this request's user has authenticated. |

### get()

`public function get(): User|ISecurityUser`

The user as of this call.

Returns [`User`](/api/user/user/)`|`[`ISecurityUser`](/api/user/i-security-user/)

### isAuthenticated()

`public function isAuthenticated(): bool`

Whether this request's user has authenticated.

False for a user that does not implement [`ISecurityUser`](/api/user/i-security-user/) at all -- an application with no security layer has no authenticated users rather than an unanswerable question.

Returns `bool`
