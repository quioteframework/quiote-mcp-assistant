# ViewTestCase

> ViewTestCase is the base class for all view testcases and provides the necessary assertions

ViewTestCase is the base class for all view testcases and provides the necessary assertions

## Synopsis

`abstract class ViewTestCase extends FragmentTestCase`

|  |  |
|---|---|
| Extends | [`FragmentTestCase`](/api/testing/fragment-test-case/) |
| Since | `1.0.0` |
| Source | `Testing/ViewTestCase.php` |

## Properties

| Property | Type | Description |
|---|---|---|
| `$viewName` | `mixed` | _protected._ |
| `$viewResult` | `mixed` | _protected._ |

## Methods

| Method | Description |
|---|---|
| [`assertHandlesOutputType(string $method, boolean $acceptGeneric = false, string $message = ''): void`](#asserthandlesoutputtype) | assert that the view handles the given output type |
| [`assertHasLayer(string $expectedLayer, string $message = 'Failed asserting that the view contains the layer "%1$s".'): void`](#asserthaslayer) | assert that the view has the given layer |
| [`assertNotHandlesOutputType(string $method, boolean $acceptGeneric = false, string $message = ''): void`](#assertnothandlesoutputtype) | assert that the view does not handle the given output type |
| [`assertNotHasLayer(string $expectedLayer, string $message = ''): void`](#assertnothaslayer) | assert that the view has the given layer |
| [`assertViewForwards(string $expectedModule, string $expectedAction, string $message = 'Failed asserting that the view forwards to "%1$s" "%2$s".'): void`](#assertviewforwards) | assert that the view forwards to the given module/action |
| [`assertViewRedirects(string $message = 'Failed asserting that the view redirects'): void`](#assertviewredirects) | assert that the response contains a redirect |
| [`assertViewRedirectsNot(string $message = 'Failed asserting that the view does not redirect'): void`](#assertviewredirectsnot) | assert that the response contains no redirect |
| [`assertViewRedirectsTo(mixed $expected, string $message = 'Failed asserting that the view redirects to the given tar…'): void`](#assertviewredirectsto) | assert that the response contains the expected redirect |
| [`assertViewResponseHasContent(mixed $expected, string $message = 'Failed asserting that the response has content <%1$s>.'): void`](#assertviewresponsehascontent) | assert that the response has the given content |
| [`assertViewResponseHasHTTPStatus(string $expected, string $message = 'Failed asserting that the response status is %1$s.'): void`](#assertviewresponsehashttpstatus) | assert that the response has the given http status this assertion only works on WebResponse or subclasses |
| [`assertViewResultEquals(mixed $expected, string $message = 'Failed asserting the expected view result.'): void`](#assertviewresultequals) | assert that the view result has the given content |
| [`assertViewSetsContentType(string $expected, string $message = 'Failed asserting that the view sets the content type "%1$s".'): void`](#assertviewsetscontenttype) | Assert that the view sets the given content type. |
| [`assertViewSetsCookie(string $expected, string $expectedValue = null, string $message = 'Failed asserting that the view sets a cookie named <%1$s>…'): void`](#assertviewsetscookie) | Assert that the view sets the given cookie with the given value.<y></y> this response only works on WebResponse and subclasses |
| [`assertViewSetsHeader(string $expected, string $expectedValue = null, string $message = 'Failed asserting that the view sets a header named <%1$s>…'): void`](#assertviewsetsheader) | Assert that the view sets the given header with the given value. |
| [`createViewInstance(): View`](#createviewinstance) | creates the view instance for this testcase, initializing it with a lightweight ImmutableViewInitContext (container-less pipeline). |
| [`getViewResponse(): WebResponse`](#getviewresponse) | Resolve the response used by the last created view instance. |
| [`runView(string $otName = null): void`](#runview) | runs the view instance for this testcase |

### assertHandlesOutputType()

`protected function assertHandlesOutputType(string $method, boolean $acceptGeneric = false, string $message = ''): void`

assert that the view handles the given output type

an optional message to display if the test fails

| Parameter | Type | Description |
|---|---|---|
| `$method` | `string` | the output type name |
| `$acceptGeneric` | `boolean` | true if the generic 'execute' method should be accepted as handled |
| `$message` | `string` | an optional message to display if the test fails |

### assertHasLayer()

`protected function assertHasLayer(string $expectedLayer, string $message = 'Failed asserting that the view contains the layer "%1$s".'): void`

assert that the view has the  given layer

the message to emit on failure

| Parameter | Type | Description |
|---|---|---|
| `$expectedLayer` | `string` | the expected layer name |
| `$message` | `string` | the message to emit on failure |

### assertNotHandlesOutputType()

`protected function assertNotHandlesOutputType(string $method, boolean $acceptGeneric = false, string $message = ''): void`

assert that the view does not handle the given output type

an optional message to display if the test fails

| Parameter | Type | Description |
|---|---|---|
| `$method` | `string` | the output type name |
| `$acceptGeneric` | `boolean` | true if the generic 'execute' method should be accepted as handled |
| `$message` | `string` | an optional message to display if the test fails |

### assertNotHasLayer()

`protected function assertNotHasLayer(string $expectedLayer, string $message = ''): void`

assert that the view has the  given layer

the message to emit on failure

| Parameter | Type | Description |
|---|---|---|
| `$expectedLayer` | `string` | the expected layer name |
| `$message` | `string` | the message to emit on failure |

### assertViewForwards()

`protected function assertViewForwards(string $expectedModule, string $expectedAction, string $message = 'Failed asserting that the view forwards to "%1$s" "%2$s".'): void`

assert that the view forwards to the given module/action

the message to emit on failure

| Parameter | Type | Description |
|---|---|---|
| `$expectedModule` | `string` | the expected module name |
| `$expectedAction` | `string` | the expected action name |
| `$message` | `string` | the message to emit on failure |

### assertViewRedirects()

`protected function assertViewRedirects(string $message = 'Failed asserting that the view redirects'): void`

assert that the response contains a redirect

the message to emit on failure

| Parameter | Type | Description |
|---|---|---|
| `$message` | `string` | the message to emit on failure |

### assertViewRedirectsNot()

`protected function assertViewRedirectsNot(string $message = 'Failed asserting that the view does not redirect'): void`

assert that the response contains no redirect

the message to emit on failure

| Parameter | Type | Description |
|---|---|---|
| `$message` | `string` | the message to emit on failure |

### assertViewRedirectsTo()

`protected function assertViewRedirectsTo(mixed $expected, string $message = 'Failed asserting that the view redirects to the given tar…'): void`

assert that the response contains the expected redirect

the message to emit on failure

| Parameter | Type | Description |
|---|---|---|
| `$expected` | `mixed` | the expected redirect |
| `$message` | `string` | the message to emit on failure |

### assertViewResponseHasContent()

`protected function assertViewResponseHasContent(mixed $expected, string $message = 'Failed asserting that the response has content <%1$s>.'): void`

assert that the response has the given content

the message to emit on failure

| Parameter | Type | Description |
|---|---|---|
| `$expected` | `mixed` | the expected content |
| `$message` | `string` | the message to emit on failure |

### assertViewResponseHasHTTPStatus()

`protected function assertViewResponseHasHTTPStatus(string $expected, string $message = 'Failed asserting that the response status is %1$s.'): void`

assert that the response has the given http status this assertion only works on WebResponse or subclasses

the message to emit on failure

| Parameter | Type | Description |
|---|---|---|
| `$expected` | `string` | the expected http status |
| `$message` | `string` | the message to emit on failure |

### assertViewResultEquals()

`protected function assertViewResultEquals(mixed $expected, string $message = 'Failed asserting the expected view result.'): void`

assert that the view result has the given content

the message to emit on failure

| Parameter | Type | Description |
|---|---|---|
| `$expected` | `mixed` | the expected content |
| `$message` | `string` | the message to emit on failure |

### assertViewSetsContentType()

`protected function assertViewSetsContentType(string $expected, string $message = 'Failed asserting that the view sets the content type "%1$s".'): void`

Assert that the view sets the given content type.

the message to emit on failure

| Parameter | Type | Description |
|---|---|---|
| `$expected` | `string` | the expected content type |
| `$message` | `string` | the message to emit on failure |

### assertViewSetsCookie()

`protected function assertViewSetsCookie(string $expected, string $expectedValue = null, string $message = 'Failed asserting that the view sets a cookie named <%1$s>…'): void`

Assert that the view sets the given cookie with the given value.<y></y> this response only works on WebResponse and subclasses

the message to emit on failure

| Parameter | Type | Description |
|---|---|---|
| `$expected` | `string` | the name of the expected cookie |
| `$expectedValue` | `string` | the value of the expected header |
| `$message` | `string` | the message to emit on failure |

### assertViewSetsHeader()

`protected function assertViewSetsHeader(string $expected, string $expectedValue = null, string $message = 'Failed asserting that the view sets a header named <%1$s>…'): void`

Assert that the view sets the given header with the given value.

the message to emit on failure

| Parameter | Type | Description |
|---|---|---|
| `$expected` | `string` | the name of the expected header |
| `$expectedValue` | `string` | the value of the expected header |
| `$message` | `string` | the message to emit on failure |

### createViewInstance()

`protected function createViewInstance(): View`

creates the view instance for this testcase, initializing it with a lightweight ImmutableViewInitContext (container-less pipeline).

Returns [`View`](/api/view/view/)

### getViewResponse()

`protected function getViewResponse(): WebResponse`

Resolve the response used by the last created view instance.

Returns [`WebResponse`](/api/response/web-response/)

### runView()

`protected function runView(string $otName = null): void`

runs the view instance for this testcase

the name of the output type to run the view for
                   null for the default output type

| Parameter | Type | Description |
|---|---|---|
| `$otName` | `string` | the name of the output type to run the view for null for the default output type |

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
| `getContext()` | [`FragmentTestCase`](/api/testing/fragment-test-case/) | Return the context defined for this test (or the default one). |
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
| `setUp()` | [`FragmentTestCase`](/api/testing/fragment-test-case/) | previously created an execution container per test; now no-op |
| `setUpBeforeClass()` | `TestCase` | This method is called before the first test of this test class is run. |
| `stringContains()` | `Assert` |  |
| `stringEndsWith()` | `Assert` |  |
| `stringEqualsStringIgnoringLineEndings()` | `Assert` |  |
| `stringEqualsStringIgnoringWhitespace()` | `Assert` |  |
| `stringStartsWith()` | `Assert` |  |
| `tearDown()` | [`FragmentTestCase`](/api/testing/fragment-test-case/) | unsets legacy container (no longer applicable) |
| `tearDownAfterClass()` | `TestCase` | This method is called after the last test of this test class is run. |
