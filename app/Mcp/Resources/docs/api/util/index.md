# Util

> The Quiote\\Util namespace — 26 documented types.

Everything under `Quiote\Util`.

## Classes

| Class | Description |
|---|---|
| [`ArrayPathDefinition`](/api/util/array-path-definition/) | Path implements handling of virtual paths This class does not implement real filesystem path handling, but uses virtual paths. |
| [`AttributeHolder`](/api/util/attribute-holder/) | AttributeHolder provides a base class for managing attributes with namespaces. |
| [`DecimalFormatter`](/api/util/decimal-formatter/) | The decimal formatter will format numbers according to a given format. |
| [`DeprecationSilencer`](/api/util/deprecation-silencer/) | Central helper to reduce noise from repetitive deprecation/notice messages during test runs. |
| [`FormPopulationConfig`](/api/util/form-population-config/) | Helper to bridge configuration storage for form population between legacy namespaced attributes and the PSR-7 attribute bag on WebRequest. |
| [`FormPopulationEngine`](/api/util/form-population-engine/) | FormPopulationFilter automatically populates a form that is re-posted, which usually happens when a View::INPUT is returned again after a POST request because an error occurred during validation. |
| [`HtmlFormRepopulator`](/api/util/html-form-repopulator/) | Lightweight HTML form repopulation utility replacing FormPopulationFilter for container-less pipeline. |
| [`Inflector`](/api/util/inflector/) | Inflector allows you to singularize or pluralize an English word |
| [`ParameterHolder`](/api/util/parameter-holder/) | ParameterHolder provides a base class for managing parameters. |
| [`QuioteXsltProcessor`](/api/util/quiote-xslt-processor/) | Extended XSLTProcessor class that throws exceptions on errors. |
| [`RecursiveDirectoryFilterIterator`](/api/util/recursive-directory-filter-iterator/) | RecursiveDirectoryFilterIterator filters a RecursiveDirectoryIterator with a given set of include and exclude patterns. |
| [`SchematronProcessor`](/api/util/schematron-processor/) | SchematronProcessor transforms DOM documents according to ISO Schematron validation and transformation rules into a document containing successful reports and failed assertions. |
| [`Toolkit`](/api/util/toolkit/) | Toolkit provides basic utility methods. |
| [`VirtualArrayPath`](/api/util/virtual-array-path/) | Path implements handling of virtual paths This class does not implement real filesystem path handling, but uses virtual paths. |
| [`WorkerManager`](/api/util/worker-manager/) | Centralized state management for any persistent worker runtime (see [`WorkerRuntimeInterface`](/api/runtime/worker/worker-runtime-interface/)), ensuring request-specific state is properly reset between requests while preserving performance-critical cached data. |

## Traits

| Trait | Description |
|---|---|
| [`InitContextAttributeAccess`](/api/util/init-context-attribute-access/) | The attribute accessor cluster shared by [`Action`](/api/action/action/) and [`View`](/api/view/view/): a facade over the attributes an execution's init context holds, so an action or view reads and writes them without knowing where they live. |

## Nested namespaces

| Namespace | Contents |
|---|---|
| [`FormPopulation`](/api/util/form-population/) | 10 types |
