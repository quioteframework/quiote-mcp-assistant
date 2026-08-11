# Testing

> The Quiote\\Testing namespace — 21 documented types.

Everything under `Quiote\Testing`.

## Classes

| Class | Description |
|---|---|
| [`ActionTestCase`](/api/testing/action-test-case/) | ActionTestCase is the base class for all action testcases and provides the necessary assertions |
| [`BaseConstraintBecausePhpunitSucksAtBackwardsCompatibility`](/api/testing/base-constraint-because-phpunit-sucks-at-backwards-compatibility/) | Base constraint that caters for breaking changes between PHPUnit 3.5 and 3.6. |
| [`ContainerTestCase`](/api/testing/container-test-case/) | ContainerTestCase is the base class for all tests that target a specific container execution and provides the necessary assertions |
| [`FragmentTestCase`](/api/testing/fragment-test-case/) | FragmentTestCase is the base class for all fragment tests and provides the necessary assertions |
| [`HttpTestCase`](/api/testing/http-test-case/) | Base class for fluent, full-pipeline HTTP tests: builds a real PSR-7 request and dispatches it through [`Context::handle()`](/api/context/#handle) (the same entry point production traffic uses), returning an assertable [`TestResponse`](/api/testing/http/test-response/). |
| [`LightweightTestContainer`](/api/testing/lightweight-test-container/) | A minimal stand-in for the execution container, used only by the PHPUnit test harness. |
| [`ModelTestCase`](/api/testing/model-test-case/) | ModelTestCase is the base class for all model testcases and provides the necessary assertions |
| [`PhpUnitTestCase`](/api/testing/php-unit-test-case/) | PhpUnitTestCase is the base class for all Quiote Testcases. |
| [`UnitTestCase`](/api/testing/unit-test-case/) | UnitTestCase is the base class for all unit testcases and provides the necessary assertions |
| [`ViewTestCase`](/api/testing/view-test-case/) | ViewTestCase is the base class for all view testcases and provides the necessary assertions |

## Interfaces

| Interface | Description |
|---|---|
| [`IFragmentTestCase`](/api/testing/i-fragment-test-case/) | IFragmentTestCase is the interface that all fragment tests must implement |
| [`ITestCase`](/api/testing/i-test-case/) | ITestCase is the interface that all quiote tests must implement |
| [`IUnitTestCase`](/api/testing/i-unit-test-case/) | IUnitTestCase is the interface that all unit tests must implement |

## Traits

| Trait | Description |
|---|---|
| [`PHPUnitTestCaseMethods`](/api/testing/phpunit-test-case-methods/) | Trait for adding PHPUnit 12 compatibility to PhpUnitTestCase |

## Nested namespaces

| Namespace | Contents |
|---|---|
| [`Attributes`](/api/testing/attributes/) | 4 types |
| [`Http`](/api/testing/http/) | 1 type |
| [`PHPUnit`](/api/testing/phpunit/) | 2 types |
