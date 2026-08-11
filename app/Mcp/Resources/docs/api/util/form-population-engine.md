# FormPopulationEngine

> FormPopulationFilter automatically populates a form that is re-posted, which usually happens when a View::INPUT is returned again after a POST request because an error occurred during validation.

FormPopulationFilter automatically populates a form that is re-posted, which usually happens when a View::INPUT is returned again after a POST request because an error occurred during validation.

That means that developers don't have to fill in request parameters into form elements in their templates anymore. Text inputs, selects, radios, they all get set to the value the user selected before submitting the form. If you would like to set default values, you still have to do that in your template. The filter will recognize this situation and automatically remove the default value you assigned after receiving a POST request. This filter only works with POST requests, and compares the form's URL and the requested URL to decide if it's appropriate to fill in a specific form it encounters while processing the output document sent back to the browser. Since this form is executed very late in the process, it works independently of any template language.

## Synopsis

`final class FormPopulationEngine`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Util/FormPopulationEngine.php` |

## Constants

| Constant | Value | Description |
|---|---|---|
| `ENCODING_ISO_8859_1` | `'iso-8859-1'` |  |
| `ENCODING_UTF_8` | `'utf-8'` |  |

## Methods

| Method | Description |
|---|---|
| [`getDefaults(): array<string, mixed>`](#getdefaults) |  |
| [`initialize(Context $context, array<string, mixed> $parameters = []): void`](#initialize) | Initialize this engine. |
| [`isPostFilter(): bool`](#ispostfilter) | Whether this engine runs after the response body has been produced. |
| [`populate(WebResponse $response, WebRequest $request, array<string, mixed> $overrides = []): void`](#populate) | Populate the provided response content with request data and validation errors. |
| [`reset(): void`](#reset) | Drops the per-response DOM state so the engine can serve the next request. |

### getDefaults()

`public function getDefaults(): array<string, mixed>`

Returns `array``<``string``, ``mixed``>`

### initialize()

`public function initialize(Context $context, array<string, mixed> $parameters = []): void`

Initialize this engine.

An associative array of initialization parameters.

| Parameter | Type | Description |
|---|---|---|
| `$context` | [`Context`](/api/context/) | The current application context. |
| `$parameters` | `array``<``string``, ``mixed``>` | An associative array of initialization parameters. |

### isPostFilter()

`public function isPostFilter(): bool`

Whether this engine runs after the response body has been produced.

Always true: population rewrites the finished (X)HTML document, so it can only run once the view has rendered.

Returns `bool`

### populate()

`public function populate(WebResponse $response, WebRequest $request, array<string, mixed> $overrides = []): void`

Populate the provided response content with request data and validation errors.

| Parameter | Type | Description |
|---|---|---|
| `$response` | [`WebResponse`](/api/response/web-response/) |  |
| `$request` | [`WebRequest`](/api/request/web-request/) |  |
| `$overrides` | `array``<``string``, ``mixed``>` |  |

### reset()

`public function reset(): void`

Drops the per-response DOM state so the engine can serve the next request.

Releases the parsed document, its XPath instance and the resolved XML namespace prefix. The configured parameters are kept -- they come from configuration, not from the request being populated.
