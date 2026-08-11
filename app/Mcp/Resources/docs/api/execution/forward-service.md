# ForwardService

> ForwardService: resolves forward targets (login / secure / custom) without creating a full execution container.

ForwardService: resolves forward targets (login / secure / custom) without creating a full execution container.

Currently only handles system forwards used by security (login, secure). Future: generalize to arbitrary forward tokens returned by actions (array/module override forms).

## Synopsis

`final class ForwardService`

|  |  |
|---|---|
| Source | `Execution/ForwardService.php` |

## Constructor

### __construct()

`public function __construct(Controller $controller, ?ViewNameResolver $resolver = null, ?ViewFactory $viewFactory = null): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$controller` | [`Controller`](/api/controller/controller/) |  |
| `$resolver` | `?`[`ViewNameResolver`](/api/execution/view-name-resolver/) |  |
| `$viewFactory` | `?`[`ViewFactory`](/api/execution/view-factory/) |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`createSystemForwardActionDescriptor(string $forwardName, string $httpMethod, string $outputType): ActionDescriptor`](#createsystemforwardactiondescriptor) | Return an ActionDescriptor for a system forward (login / secure) honoring settings.xml mappings. |
| [`createSystemForwardView(string $forwardName, string $outputType, WebRequest $rd): array{0: ?\Quiote\View\View, 1: string, 2: string, 3: string}`](#createsystemforwardview) | Legacy temporary method (now deprecated) that tried to short-circuit by rendering a view. |

### createSystemForwardActionDescriptor()

`public function createSystemForwardActionDescriptor(string $forwardName, string $httpMethod, string $outputType): ActionDescriptor`

Return an ActionDescriptor for a system forward (login / secure) honoring settings.xml mappings.

| Parameter | Type | Description |
|---|---|---|
| `$forwardName` | `string` |  |
| `$httpMethod` | `string` |  |
| `$outputType` | `string` |  |

Returns [`ActionDescriptor`](/api/execution/action-descriptor/)

### createSystemForwardView()

`public function createSystemForwardView(string $forwardName, string $outputType, WebRequest $rd): array{0: ?\Quiote\View\View, 1: string, 2: string, 3: string}`

Legacy temporary method (now deprecated) that tried to short-circuit by rendering a view.

Left in place for transitional callers; now simply delegates to descriptor path and returns empty content.

| Parameter | Type | Description |
|---|---|---|
| `$forwardName` | `string` |  |
| `$outputType` | `string` |  |
| `$rd` | [`WebRequest`](/api/request/web-request/) |  |

Returns `array{0: ?\Quiote\View\View, 1: string, 2: string, 3: string}`
