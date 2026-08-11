# FormFinder

> Decides which forms in the document get populated, and from what.

Decides which forms in the document get populated, and from what.

There are two ways a caller says which form it means. A ParameterHolder means "the form this request was submitted to", identified by comparing the form's action against the request -- which is why the comparison below accepts an absolute URL, a root-relative path, and a path relative to any <base href>, since a template may have written any of the three. An array keyed by form id means "these specific forms, each from its own data", and skips the action comparison entirely.

Forms named by id are returned in the order the caller listed them, not in document order: error insertion happens as forms are visited, and a re-populated form must be visited before the others.

## Synopsis

`final readonly class FormFinder`

|  |  |
|---|---|
| Source | `Util/FormPopulation/FormFinder.php` |

## Constructor

### __construct()

`public function __construct(\Closure(string, ?\DOMElement): array<int, \DOMElement> $queryElements, string $xmlnsPrefix): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$queryElements` | `\Closure(string, ?\DOMElement): array<int, \DOMElement>` |  |
| `$xmlnsPrefix` | `string` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`dataFor(DOMElement $element, mixed $populate, string $requestUri, string $requestUrl, string $baseHref, ?ParameterHolder $fallback): ?ParameterHolder`](#datafor) | The data a given form is populated from, or null when it is not this request's form and should be left alone. |
| [`find(mixed $populate, array<string, mixed> $cfg): array<int, DOMElement>`](#find) | The form elements to populate, in the order they should be visited. |

### dataFor()

`public function dataFor(DOMElement $element, mixed $populate, string $requestUri, string $requestUrl, string $baseHref, ?ParameterHolder $fallback): ?ParameterHolder`

The data a given form is populated from, or null when it is not this request's form and should be left alone.

$fallback supplies the data for a non-form container element, which the forms_xpath configuration can select and which has no action to compare.

| Parameter | Type | Description |
|---|---|---|
| `$element` | `DOMElement` |  |
| `$populate` | `mixed` |  |
| `$requestUri` | `string` |  |
| `$requestUrl` | `string` |  |
| `$baseHref` | `string` |  |
| `$fallback` | `?`[`ParameterHolder`](/api/util/parameter-holder/) |  |

Returns `?`[`ParameterHolder`](/api/util/parameter-holder/)

### find()

`public function find(mixed $populate, array<string, mixed> $cfg): array<int, DOMElement>`

The form elements to populate, in the order they should be visited.

| Parameter | Type | Description |
|---|---|---|
| `$populate` | `mixed` |  |
| `$cfg` | `array``<``string``, ``mixed``>` |  |

Returns `array``<``int``, ``DOMElement``>`
