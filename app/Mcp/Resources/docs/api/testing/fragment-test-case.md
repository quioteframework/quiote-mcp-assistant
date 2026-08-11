# FragmentTestCase

> FragmentTestCase is the base class for all fragment tests and provides the necessary assertions

FragmentTestCase is the base class for all fragment tests and provides the necessary assertions

## Synopsis

`abstract class FragmentTestCase extends PhpUnitTestCase implements IFragmentTestCase`

|  |  |
|---|---|
| Extends | [`PhpUnitTestCase`](/api/testing/php-unit-test-case/) |
| Implements | [`IFragmentTestCase`](/api/testing/i-fragment-test-case/) |
| Since | `1.0.0` |
| Source | `Testing/FragmentTestCase.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$actionName` | `mixed` | _protected._ |
| `$container` | `mixed` | _protected._ |
| `$contextName` | `mixed` | _protected._ |
| `$moduleName` | `mixed` | _protected._ |
| `$requestMethod` | `mixed` | _protected._ |
| `$validationSuccess` | `mixed` | _protected._ |

## Methods

| Method | Description |
|---|---|
| [`appendAttribute(string $name, mixed $value): void`](#appendattribute) |  |
| [`appendAttributeByRef(string $name, mixed &$value): void`](#appendattributebyref) |  |
| [`applyRequestParameters(array<string, mixed> $parameters, bool $clearFirst = false): void`](#applyrequestparameters) | Helper: apply runtime parameters directly to canonical WebRequest (replaces deprecated DataHolder usage). |
| [`assertContainerAttributeEquals(mixed $expected, string $attributeName, string $namespace = null, string $message = 'Failed asserting that the attribute <%1$s/%2$s> has the v…', float $delta = 0, integer $maxDepth = 10, boolean $canonicalizeEol = false): void`](#assertcontainerattributeequals) | assert that the test container has a given attribute with the expected value |
| [`assertContainerAttributeExists(string $attributeName, string $namespace = null, string $message = 'Failed asserting that the container has an attribute name…'): void`](#assertcontainerattributeexists) | assert that the exectionContainer has a given attribute |
| [`clearAttributes(): void`](#clearattributes) |  |
| [`clearSingletonModels(): void`](#clearsingletonmodels) | Drop the shared model instances, so a test that mutated one does not hand it to the next. |
| [`createActionInstance(): Action`](#createactioninstance) | creates an Action instance and initializes it with this testcase's init context |
| [`createRequestDataHolder(array<int|string, mixed> $arguments = [], mixed $type = null): array<int|string, mixed>`](#createrequestdataholder) | (Deprecated) Legacy helper that previously created an RequestDataHolder instance. |
| [`getAttribute(string $name, mixed $default = null): mixed`](#getattribute) |  |
| [`getAttributeNames(): array<int, string>`](#getattributenames) |  |
| [`getAttributes(): array<string, mixed>`](#getattributes) |  |
| [`getContext(): Context`](#getcontext) | Return the context defined for this test (or the default one). |
| [`hasAttribute(string $name): bool`](#hasattribute) |  |
| [`normalizeViewName(string $shortName): string`](#normalizeviewname) | normalizes a viewname according to the configured rules Please do not use this method, it exists only for internal purposes and will be removed ASAP. |
| [`removeAttribute(string $name): mixed`](#removeattribute) |  |
| [`setArguments(mixed $arguments): void`](#setarguments) |  |
| [`setAttribute(string $name, mixed $value): void`](#setattribute) |  |
| [`setAttributeByRef(string $name, mixed &$value): void`](#setattributebyref) |  |
| [`setAttributes(array<string, mixed> $attributes): void`](#setattributes) |  |
| [`setAttributesByRef(array<string, mixed> &$attributes): void`](#setattributesbyref) |  |
| [`setOutputType(OutputType $outputType): void`](#setoutputtype) |  |
| [`setRequestData(mixed $rd): void`](#setrequestdata) |  |
| [`setRequestMethod(string $method): void`](#setrequestmethod) |  |
| [`setUp(): void`](#setup) | previously created an execution container per test; now no-op |
| [`tearDown(): void`](#teardown) | unsets legacy container (no longer applicable) |

### appendAttribute()

`protected function appendAttribute(string $name, mixed $value): void`

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$value` | `mixed` |  |

### appendAttributeByRef()

`protected function appendAttributeByRef(string $name, mixed &$value): void`

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$value` | `mixed` |  |

### applyRequestParameters()

`protected function applyRequestParameters(array<string, mixed> $parameters, bool $clearFirst = false): void`

Helper: apply runtime parameters directly to canonical WebRequest (replaces deprecated DataHolder usage).

| Parameter | Type | Description |
|---|---|---|
| `$parameters` | `array``<``string``, ``mixed``>` |  |
| `$clearFirst` | `bool` |  |

### assertContainerAttributeEquals()

`protected function assertContainerAttributeEquals(mixed $expected, string $attributeName, string $namespace = null, string $message = 'Failed asserting that the attribute <%1$s/%2$s> has the v…', float $delta = 0, integer $maxDepth = 10, boolean $canonicalizeEol = false): void`

assert that the test container has a given attribute with the expected value

| Parameter | Type | Description |
|---|---|---|
| `$expected` | `mixed` | the expected attribute value |
| `$attributeName` | `string` | the attribute name |
| `$namespace` | `string` | the attribute namespace |
| `$message` | `string` | an optional message to display if the test fails |
| `$delta` | `float` |  |
| `$maxDepth` | `integer` |  |
| `$canonicalizeEol` | `boolean` |  |

### assertContainerAttributeExists()

`protected function assertContainerAttributeExists(string $attributeName, string $namespace = null, string $message = 'Failed asserting that the container has an attribute name…'): void`

assert that the exectionContainer has a given attribute

an optional message to display if the test fails

| Parameter | Type | Description |
|---|---|---|
| `$attributeName` | `string` | the attribute name |
| `$namespace` | `string` | the attribute namespace |
| `$message` | `string` | an optional message to display if the test fails |

### clearAttributes()

`protected function clearAttributes(): void`

### clearSingletonModels()

`protected function clearSingletonModels(): void`

Drop the shared model instances, so a test that mutated one does not hand it to the next.

The model locator owns those instances and clears them itself at a worker request boundary, so this asks it rather than reaching into the context.

### createActionInstance()

`protected function createActionInstance(): Action`

creates an Action instance and initializes it with this testcase's init context

Returns [`Action`](/api/action/action/)

### createRequestDataHolder()

`protected function createRequestDataHolder(array<int|string, mixed> $arguments = [], mixed $type = null): array<int|string, mixed>`

(Deprecated) Legacy helper that previously created an RequestDataHolder instance.

| Parameter | Type | Description |
|---|---|---|
| `$arguments` | `array``<``int``|``string``, ``mixed``>` |  |
| `$type` | `mixed` |  |

Returns `array``<``int``|``string``, ``mixed``>`

### getAttribute()

`protected function getAttribute(string $name, mixed $default = null): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$default` | `mixed` |  |

Returns `mixed`

### getAttributeNames()

`protected function getAttributeNames(): array<int, string>`

Returns `array``<``int``, ``string``>`

### getAttributes()

`protected function getAttributes(): array<string, mixed>`

Returns `array``<``string``, ``mixed``>`

### getContext()

`public function getContext(): Context`

Return the context defined for this test (or the default one).

Returns [`Context`](/api/context/) — The context instance defined for this test.

### hasAttribute()

`protected function hasAttribute(string $name): bool`

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |

Returns `bool`

### normalizeViewName()

`protected function normalizeViewName(string $shortName): string`

normalizes a viewname according to the configured rules Please do not use this method, it exists only for internal purposes and will be removed ASAP.

the short view name

| Parameter | Type | Description |
|---|---|---|
| `$shortName` | `string` | the short view name |

Returns `string` — the full view name

### removeAttribute()

`protected function removeAttribute(string $name): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |

Returns `mixed`

### setArguments()

`protected function setArguments(mixed $arguments): void`

| Parameter | Type | Description |
|---|---|---|
| `$arguments` | `mixed` |  |

### setAttribute()

`protected function setAttribute(string $name, mixed $value): void`

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$value` | `mixed` |  |

### setAttributeByRef()

`protected function setAttributeByRef(string $name, mixed &$value): void`

| Parameter | Type | Description |
|---|---|---|
| `$name` | `string` |  |
| `$value` | `mixed` |  |

### setAttributes()

`protected function setAttributes(array<string, mixed> $attributes): void`

| Parameter | Type | Description |
|---|---|---|
| `$attributes` | `array``<``string``, ``mixed``>` |  |

### setAttributesByRef()

`protected function setAttributesByRef(array<string, mixed> &$attributes): void`

| Parameter | Type | Description |
|---|---|---|
| `$attributes` | `array``<``string``, ``mixed``>` |  |

### setOutputType()

`protected function setOutputType(OutputType $outputType): void`

| Parameter | Type | Description |
|---|---|---|
| `$outputType` | [`OutputType`](/api/controller/output-type/) |  |

### setRequestData()

`protected function setRequestData(mixed $rd): void`

| Parameter | Type | Description |
|---|---|---|
| `$rd` | `mixed` |  |

### setRequestMethod()

`protected function setRequestMethod(string $method): void`

| Parameter | Type | Description |
|---|---|---|
| `$method` | `string` |  |

### setUp()

`public function setUp(): void`

previously created an execution container per test; now no-op

### tearDown()

`public function tearDown(): void`

unsets legacy container (no longer applicable)

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `anything()` | `Assert` |  |
| `arrayHasKey()` | `Assert` |  |
| `assertArrayHasKey()` | `Assert` | Asserts that an array has a specified key. |
| `assertArrayIsEqualToArrayIgnoringListOfKeys()` | `Assert` | Asserts that two arrays are equal while ignoring a list of keys. |
| `assertArrayIsEqualToArrayOnlyConsideringListOfKeys()` | `Assert` | Asserts that two arrays are equal while only considering a list of keys. |
| `assertArrayIsIdenticalToArrayIgnoringListOfKeys()` | `Assert` | Asserts that two arrays are equal while ignoring a list of keys. |
| `assertArrayIsIdenticalToArrayOnlyConsideringListOfKeys()` | `Assert` | Asserts that two arrays are identical while only considering a list of keys. |
| `assertArrayNotHasKey()` | `Assert` | Asserts that an array does not have a specified key. |
| `assertArraysAreEqual()` | `Assert` | Assert that two arrays are equal. |
| `assertArraysAreEqualIgnoringOrder()` | `Assert` | Assert that two arrays are equal while ignoring the order of their values. |
| `assertArraysAreIdentical()` | `Assert` | Assert that two arrays are identical. |
| `assertArraysAreIdenticalIgnoringOrder()` | `Assert` | Assert that two arrays are identical while ignoring the order of their values. |
| `assertArraysHaveEqualValues()` | `Assert` | Assert that two arrays have equal values. |
| `assertArraysHaveEqualValuesIgnoringOrder()` | `Assert` | Assert that two arrays have equal values while ignoring the order of these values. |
| `assertArraysHaveIdenticalValues()` | `Assert` | Assert that two arrays have identical values. |
| `assertArraysHaveIdenticalValuesIgnoringOrder()` | `Assert` | Assert that two arrays have identical values while ignoring the order of these values. |
| `assertContains()` | `Assert` | Asserts that a haystack contains a needle. |
| `assertContainsEquals()` | `Assert` |  |
| `assertContainsNotOnlyArray()` | `Assert` | Asserts that a haystack does not contain only values of type array. |
| `assertContainsNotOnlyBool()` | `Assert` | Asserts that a haystack does not contain only values of type bool. |
| `assertContainsNotOnlyCallable()` | `Assert` | Asserts that a haystack does not contain only values of type callable. |
| `assertContainsNotOnlyClosedResource()` | `Assert` | Asserts that a haystack does not contain only values of type closed resource. |
| `assertContainsNotOnlyFloat()` | `Assert` | Asserts that a haystack does not contain only values of type float. |
| `assertContainsNotOnlyInstancesOf()` | `Assert` | Asserts that a haystack does not contain only instances of a specified interface or class name. |
| `assertContainsNotOnlyInt()` | `Assert` | Asserts that a haystack does not contain only values of type int. |
| `assertContainsNotOnlyIterable()` | `Assert` | Asserts that a haystack does not contain only values of type iterable. |
| `assertContainsNotOnlyNull()` | `Assert` | Asserts that a haystack does not contain only values of type null. |
| `assertContainsNotOnlyNumeric()` | `Assert` | Asserts that a haystack does not contain only values of type numeric. |
| `assertContainsNotOnlyObject()` | `Assert` | Asserts that a haystack does not contain only values of type object. |
| `assertContainsNotOnlyResource()` | `Assert` | Asserts that a haystack does not contain only values of type resource. |
| `assertContainsNotOnlyScalar()` | `Assert` | Asserts that a haystack does not contain only values of type scalar. |
| `assertContainsNotOnlyString()` | `Assert` | Asserts that a haystack does not contain only values of type string. |
| `assertContainsOnlyArray()` | `Assert` | Asserts that a haystack contains only values of type array. |
| `assertContainsOnlyBool()` | `Assert` | Asserts that a haystack contains only values of type bool. |
| `assertContainsOnlyCallable()` | `Assert` | Asserts that a haystack contains only values of type callable. |
| `assertContainsOnlyClosedResource()` | `Assert` | Asserts that a haystack contains only values of type closed resource. |
| `assertContainsOnlyFloat()` | `Assert` | Asserts that a haystack contains only values of type float. |
| `assertContainsOnlyInstancesOf()` | `Assert` | Asserts that a haystack contains only instances of a specified interface or class name. |
| `assertContainsOnlyInt()` | `Assert` | Asserts that a haystack contains only values of type int. |
| `assertContainsOnlyIterable()` | `Assert` | Asserts that a haystack contains only values of type iterable. |
| `assertContainsOnlyNull()` | `Assert` | Asserts that a haystack contains only values of type null. |
| `assertContainsOnlyNumeric()` | `Assert` | Asserts that a haystack contains only values of type numeric. |
| `assertContainsOnlyObject()` | `Assert` | Asserts that a haystack contains only values of type object. |
| `assertContainsOnlyResource()` | `Assert` | Asserts that a haystack contains only values of type resource. |
| `assertContainsOnlyScalar()` | `Assert` | Asserts that a haystack contains only values of type scalar. |
| `assertContainsOnlyString()` | `Assert` | Asserts that a haystack contains only values of type string. |
| `assertCount()` | `Assert` | Asserts the number of elements of an array, Countable or Traversable. |
| `assertDirectoryDoesNotExist()` | `Assert` | Asserts that a directory does not exist. |
| `assertDirectoryExists()` | `Assert` | Asserts that a directory exists. |
| `assertDirectoryIsNotReadable()` | `Assert` | Asserts that a directory exists and is not readable. |
| `assertDirectoryIsNotWritable()` | `Assert` | Asserts that a directory exists and is not writable. |
| `assertDirectoryIsReadable()` | `Assert` | Asserts that a directory exists and is readable. |
| `assertDirectoryIsWritable()` | `Assert` | Asserts that a directory exists and is writable. |
| `assertDoesNotMatchRegularExpression()` | `Assert` | Asserts that a string does not match a given regular expression. |
| `assertEmpty()` | `Assert` | Asserts that a variable is empty. |
| `assertEquals()` | `Assert` | Asserts that two variables are equal. |
| `assertEqualsCanonicalizing()` | `Assert` | Asserts that two variables are equal (canonicalizing). |
| `assertEqualsIgnoringCase()` | `Assert` | Asserts that two variables are equal (ignoring case). |
| `assertEqualsWithDelta()` | `Assert` | Asserts that two variables are equal (with delta). |
| `assertFalse()` | `Assert` | Asserts that a condition is false. |
| `assertFileDoesNotExist()` | `Assert` | Asserts that a file does not exist. |
| `assertFileEquals()` | `Assert` | Asserts that the contents of one file is equal to the contents of another file. |
| `assertFileEqualsCanonicalizing()` | `Assert` | Asserts that the contents of one file is equal to the contents of another file (canonicalizing). |
| `assertFileEqualsFileIgnoringWhitespace()` | `Assert` | Asserts that the contents of one file is equal to the contents of another file (ignoring whitespace). |
| `assertFileEqualsIgnoringCase()` | `Assert` | Asserts that the contents of one file is equal to the contents of another file (ignoring case). |
| `assertFileExists()` | `Assert` | Asserts that a file exists. |
| `assertFileIsNotReadable()` | `Assert` | Asserts that a file exists and is not readable. |
| `assertFileIsNotWritable()` | `Assert` | Asserts that a file exists and is not writable. |
| `assertFileIsReadable()` | `Assert` | Asserts that a file exists and is readable. |
| `assertFileIsWritable()` | `Assert` | Asserts that a file exists and is writable. |
| `assertFileMatchesFormat()` | `Assert` | Asserts that a string matches a given format string. |
| `assertFileMatchesFormatFile()` | `Assert` | Asserts that a string matches a given format string. |
| `assertFileNotEquals()` | `Assert` | Asserts that the contents of one file is not equal to the contents of another file. |
| `assertFileNotEqualsCanonicalizing()` | `Assert` | Asserts that the contents of one file is not equal to the contents of another file (canonicalizing). |
| `assertFileNotEqualsFileIgnoringWhitespace()` | `Assert` | Asserts that the contents of one file is not equal to the contents of another file (ignoring whitespace). |
| `assertFileNotEqualsIgnoringCase()` | `Assert` | Asserts that the contents of one file is not equal to the contents of another file (ignoring case). |
| `assertFinite()` | `Assert` | Asserts that a variable is finite. |
| `assertGreaterThan()` | `Assert` | Asserts that a value is greater than another value. |
| `assertGreaterThanOrEqual()` | `Assert` | Asserts that a value is greater than or equal to another value. |
| `assertInfinite()` | `Assert` | Asserts that a variable is infinite. |
| `assertInstanceOf()` | `Assert` | Asserts that a variable is of a given type. |
| `assertIsArray()` | `Assert` | Asserts that a variable is of type array. |
| `assertIsBool()` | `Assert` | Asserts that a variable is of type bool. |
| `assertIsCallable()` | `Assert` | Asserts that a variable is of type callable. |
| `assertIsClosedResource()` | `Assert` | Asserts that a variable is of type resource and is closed. |
| `assertIsFloat()` | `Assert` | Asserts that a variable is of type float. |
| `assertIsInt()` | `Assert` | Asserts that a variable is of type int. |
| `assertIsIterable()` | `Assert` | Asserts that a variable is of type iterable. |
| `assertIsList()` | `Assert` |  |
| `assertIsNotArray()` | `Assert` | Asserts that a variable is not of type array. |
| `assertIsNotBool()` | `Assert` | Asserts that a variable is not of type bool. |
| `assertIsNotCallable()` | `Assert` | Asserts that a variable is not of type callable. |
| `assertIsNotClosedResource()` | `Assert` | Asserts that a variable is not of type resource. |
| `assertIsNotFloat()` | `Assert` | Asserts that a variable is not of type float. |
| `assertIsNotInt()` | `Assert` | Asserts that a variable is not of type int. |
| `assertIsNotIterable()` | `Assert` | Asserts that a variable is not of type iterable. |
| `assertIsNotNumeric()` | `Assert` | Asserts that a variable is not of type numeric. |
| `assertIsNotObject()` | `Assert` | Asserts that a variable is not of type object. |
| `assertIsNotReadable()` | `Assert` | Asserts that a file/dir exists and is not readable. |
| `assertIsNotResource()` | `Assert` | Asserts that a variable is not of type resource. |
| `assertIsNotScalar()` | `Assert` | Asserts that a variable is not of type scalar. |
| `assertIsNotString()` | `Assert` | Asserts that a variable is not of type string. |
| `assertIsNotWritable()` | `Assert` | Asserts that a file/dir exists and is not writable. |
| `assertIsNumeric()` | `Assert` | Asserts that a variable is of type numeric. |
| `assertIsObject()` | `Assert` | Asserts that a variable is of type object. |
| `assertIsReadable()` | `Assert` | Asserts that a file/dir is readable. |
| `assertIsResource()` | `Assert` | Asserts that a variable is of type resource. |
| `assertIsScalar()` | `Assert` | Asserts that a variable is of type scalar. |
| `assertIsString()` | `Assert` | Asserts that a variable is of type string. |
| `assertIsWritable()` | `Assert` | Asserts that a file/dir exists and is writable. |
| `assertJson()` | `Assert` | Asserts that a string is a valid JSON string. |
| `assertJsonFileEqualsJsonFile()` | `Assert` | Asserts that two JSON files are equal. |
| `assertJsonFileNotEqualsJsonFile()` | `Assert` | Asserts that two JSON files are not equal. |
| `assertJsonStringEqualsJsonFile()` | `Assert` | Asserts that the generated JSON encoded object and the content of the given file are equal. |
| `assertJsonStringEqualsJsonString()` | `Assert` | Asserts that two given JSON encoded objects or arrays are equal. |
| `assertJsonStringNotEqualsJsonFile()` | `Assert` | Asserts that the generated JSON encoded object and the content of the given file are not equal. |
| `assertJsonStringNotEqualsJsonString()` | `Assert` | Asserts that two given JSON encoded objects or arrays are not equal. |
| `assertLessThan()` | `Assert` | Asserts that a value is smaller than another value. |
| `assertLessThanOrEqual()` | `Assert` | Asserts that a value is smaller than or equal to another value. |
| `assertMatchesRegularExpression()` | `Assert` | Asserts that a string matches a given regular expression. |
| `assertNan()` | `Assert` | Asserts that a variable is nan. |
| `assertNotContains()` | `Assert` | Asserts that a haystack does not contain a needle. |
| `assertNotContainsEquals()` | `Assert` |  |
| `assertNotCount()` | `Assert` | Asserts the number of elements of an array, Countable or Traversable. |
| `assertNotEmpty()` | `Assert` | Asserts that a variable is not empty. |
| `assertNotEquals()` | `Assert` | Asserts that two variables are not equal. |
| `assertNotEqualsCanonicalizing()` | `Assert` | Asserts that two variables are not equal (canonicalizing). |
| `assertNotEqualsIgnoringCase()` | `Assert` | Asserts that two variables are not equal (ignoring case). |
| `assertNotEqualsWithDelta()` | `Assert` | Asserts that two variables are not equal (with delta). |
| `assertNotFalse()` | `Assert` | Asserts that a condition is not false. |
| `assertNotInstanceOf()` | `Assert` | Asserts that a variable is not of a given type. |
| `assertNotNull()` | `Assert` | Asserts that a variable is not null. |
| `assertNotSame()` | `Assert` | Asserts that two variables do not have the same type and value. |
| `assertNotSameSize()` | `Assert` | Assert that the size of two arrays (or `Countable` or `Traversable` objects) is not the same. |
| `assertNotTrue()` | `Assert` | Asserts that a condition is not true. |
| `assertNull()` | `Assert` | Asserts that a variable is null. |
| `assertObjectEquals()` | `Assert` |  |
| `assertObjectHasProperty()` | `Assert` | Asserts that an object has a specified property. |
| `assertObjectNotEquals()` | `Assert` |  |
| `assertObjectNotHasProperty()` | `Assert` | Asserts that an object does not have a specified property. |
| `assertSame()` | `Assert` | Asserts that two variables have the same type and value. |
| `assertSameSize()` | `Assert` | Assert that the size of two arrays (or `Countable` or `Traversable` objects) is the same. |
| `assertStringContainsString()` | `Assert` |  |
| `assertStringContainsStringIgnoringCase()` | `Assert` |  |
| `assertStringContainsStringIgnoringLineEndings()` | `Assert` |  |
| `assertStringEndsNotWith()` | `Assert` | Asserts that a string ends not with a given suffix. |
| `assertStringEndsWith()` | `Assert` | Asserts that a string ends with a given suffix. |
| `assertStringEqualsFile()` | `Assert` | Asserts that the contents of a string is equal to the contents of a file. |
| `assertStringEqualsFileCanonicalizing()` | `Assert` | Asserts that the contents of a string is equal to the contents of a file (canonicalizing). |
| `assertStringEqualsFileIgnoringCase()` | `Assert` | Asserts that the contents of a string is equal to the contents of a file (ignoring case). |
| `assertStringEqualsFileIgnoringWhitespace()` | `Assert` | Asserts that the contents of a string is equal to the contents of a file (ignoring whitespace). |
| `assertStringEqualsStringIgnoringLineEndings()` | `Assert` | Asserts that two strings are equal except for line endings. |
| `assertStringEqualsStringIgnoringWhitespace()` | `Assert` | Asserts that two strings are equal ignoring whitespace. |
| `assertStringMatchesFormat()` | `Assert` | Asserts that a string matches a given format string. |
| `assertStringMatchesFormatFile()` | `Assert` | Asserts that a string matches a given format file. |
| `assertStringNotContainsString()` | `Assert` |  |
| `assertStringNotContainsStringIgnoringCase()` | `Assert` |  |
| `assertStringNotEqualsFile()` | `Assert` | Asserts that the contents of a string is not equal to the contents of a file. |
| `assertStringNotEqualsFileCanonicalizing()` | `Assert` | Asserts that the contents of a string is not equal to the contents of a file (canonicalizing). |
| `assertStringNotEqualsFileIgnoringCase()` | `Assert` | Asserts that the contents of a string is not equal to the contents of a file (ignoring case). |
| `assertStringNotEqualsFileIgnoringWhitespace()` | `Assert` | Asserts that the contents of a string is not equal to the contents of a file (ignoring whitespace). |
| `assertStringNotEqualsStringIgnoringWhitespace()` | `Assert` | Asserts that two strings are not equal ignoring whitespace. |
| `assertStringStartsNotWith()` | `Assert` | Asserts that a string starts not with a given prefix. |
| `assertStringStartsWith()` | `Assert` | Asserts that a string starts with a given prefix. |
| `assertThat()` | `Assert` | Evaluates a PHPUnit\Framework\Constraint matcher object. |
| `assertTrue()` | `Assert` | Asserts that a condition is true. |
| `assertXmlFileEqualsXmlFile()` | `Assert` | Asserts that two XML files are equal, ignoring comments. |
| `assertXmlFileEqualsXmlFileConsideringComments()` | `Assert` | Asserts that two XML files are equal, considering comments. |
| `assertXmlFileNotEqualsXmlFile()` | `Assert` | Asserts that two XML files are not equal, ignoring comments. |
| `assertXmlFileNotEqualsXmlFileConsideringComments()` | `Assert` | Asserts that two XML files are not equal, considering comments. |
| `assertXmlStringEqualsXmlFile()` | `Assert` | Asserts that two XML documents are equal, ignoring comments. |
| `assertXmlStringEqualsXmlFileConsideringComments()` | `Assert` | Asserts that two XML documents are equal, considering comments. |
| `assertXmlStringEqualsXmlString()` | `Assert` | Asserts that two XML documents are equal, ignoring comments. |
| `assertXmlStringEqualsXmlStringConsideringComments()` | `Assert` | Asserts that two XML documents are equal, considering comments. |
| `assertXmlStringNotEqualsXmlFile()` | `Assert` | Asserts that two XML documents are not equal, ignoring comments. |
| `assertXmlStringNotEqualsXmlFileConsideringComments()` | `Assert` | Asserts that two XML documents are not equal, considering comments. |
| `assertXmlStringNotEqualsXmlString()` | `Assert` | Asserts that two XML documents are not equal, ignoring comments. |
| `assertXmlStringNotEqualsXmlStringConsideringComments()` | `Assert` | Asserts that two XML documents are not equal, considering comments. |
| `callback()` | `Assert` |  |
| `containsEqual()` | `Assert` |  |
| `containsIdentical()` | `Assert` |  |
| `containsOnlyArray()` | `Assert` |  |
| `containsOnlyBool()` | `Assert` |  |
| `containsOnlyCallable()` | `Assert` |  |
| `containsOnlyClosedResource()` | `Assert` |  |
| `containsOnlyFloat()` | `Assert` |  |
| `containsOnlyInstancesOf()` | `Assert` |  |
| `containsOnlyInt()` | `Assert` |  |
| `containsOnlyIterable()` | `Assert` |  |
| `containsOnlyNull()` | `Assert` |  |
| `containsOnlyNumeric()` | `Assert` |  |
| `containsOnlyObject()` | `Assert` |  |
| `containsOnlyResource()` | `Assert` |  |
| `containsOnlyScalar()` | `Assert` |  |
| `containsOnlyString()` | `Assert` |  |
| `countOf()` | `Assert` |  |
| `createAttribute()` | [`PhpUnitTestCase`](/api/testing/php-unit-test-case/) | Create attributes for custom annotations |
| `directoryExists()` | `Assert` |  |
| `equalTo()` | `Assert` |  |
| `equalToCanonicalizing()` | `Assert` |  |
| `equalToIgnoringCase()` | `Assert` |  |
| `equalToWithDelta()` | `Assert` |  |
| `fail()` | `Assert` | Fails a test with the given message. |
| `fileExists()` | `Assert` |  |
| `getClearCache()` | [`PhpUnitTestCase`](/api/testing/php-unit-test-case/) | check whether to clear the cache in isolated tests |
| `getCount()` | `Assert` | Return the current assertion count. |
| `getIsolationDefaultContext()` | [`PhpUnitTestCase`](/api/testing/php-unit-test-case/) | get the default context to use in isolated tests |
| `getIsolationEnvironment()` | [`PhpUnitTestCase`](/api/testing/php-unit-test-case/) | get the environment to bootstrap in isolated tests |
| `greaterThan()` | `Assert` |  |
| `greaterThanOrEqual()` | `Assert` |  |
| `identicalTo()` | `Assert` |  |
| `isArray()` | `Assert` |  |
| `isBool()` | `Assert` |  |
| `isCallable()` | `Assert` |  |
| `isClosedResource()` | `Assert` |  |
| `isEmpty()` | `Assert` |  |
| `isFalse()` | `Assert` |  |
| `isFinite()` | `Assert` |  |
| `isFloat()` | `Assert` |  |
| `isInfinite()` | `Assert` |  |
| `isInstanceOf()` | `Assert` |  |
| `isInt()` | `Assert` |  |
| `isIterable()` | `Assert` |  |
| `isJson()` | `Assert` |  |
| `isList()` | `Assert` |  |
| `isNan()` | `Assert` |  |
| `isNull()` | `Assert` |  |
| `isNumeric()` | `Assert` |  |
| `isObject()` | `Assert` |  |
| `isReadable()` | `Assert` |  |
| `isResource()` | `Assert` |  |
| `isScalar()` | `Assert` |  |
| `isString()` | `Assert` |  |
| `isTrue()` | `Assert` |  |
| `isWritable()` | `Assert` |  |
| `lessThan()` | `Assert` |  |
| `lessThanOrEqual()` | `Assert` |  |
| `logicalAnd()` | `Assert` |  |
| `logicalNot()` | `Assert` |  |
| `logicalOr()` | `Assert` |  |
| `logicalXor()` | `Assert` |  |
| `markTestIncomplete()` | `Assert` | Mark the test as incomplete. |
| `markTestSkipped()` | `Assert` | Mark the test as skipped. |
| `matches()` | `Assert` |  |
| `matchesRegularExpression()` | `Assert` |  |
| `objectEquals()` | `Assert` |  |
| `resetCount()` | `Assert` | Reset the assertion counter. |
| `setClearCache()` | [`PhpUnitTestCase`](/api/testing/php-unit-test-case/) | set whether the cache should be cleared for the isolated subprocess |
| `setIsolationDefaultContext()` | [`PhpUnitTestCase`](/api/testing/php-unit-test-case/) | set the default context to use in isolated tests |
| `setIsolationEnvironment()` | [`PhpUnitTestCase`](/api/testing/php-unit-test-case/) | set the environment to bootstrap in isolated tests |
| `setUpBeforeClass()` | `TestCase` | This method is called before the first test of this test class is run. |
| `stringContains()` | `Assert` |  |
| `stringEndsWith()` | `Assert` |  |
| `stringEqualsStringIgnoringLineEndings()` | `Assert` |  |
| `stringEqualsStringIgnoringWhitespace()` | `Assert` |  |
| `stringStartsWith()` | `Assert` |  |
| `tearDownAfterClass()` | `TestCase` | This method is called after the last test of this test class is run. |
