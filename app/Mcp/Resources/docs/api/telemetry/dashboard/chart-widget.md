# ChartWidget

> A leaf widget that renders a numeric series as a multi-row bar chart, filling whatever height and width it is assigned at render time.

A leaf widget that renders a numeric series as a multi-row bar chart, filling whatever height and width it is assigned at render time.

This is what makes the dashboard's throughput/latency panels genuinely tall (not the single glyph row [`Spark`](/api/telemetry/dashboard/spark/)'s original design produced) and responsive to terminal resizes: `render()` reads `$context->getRows()`/ `getColumns()` fresh on every frame and re-resamples/re-draws to fit.

Implements `VerticallyExpandableInterface` directly on a leaf widget (`symfony/tui` only ships this on `ContainerWidget`/`EditorWidget`, but the interface itself has no such restriction) so a plain `ContainerWidget` ancestor's `isVerticallyExpanded()` -- "true if explicitly set, or if any * child needs to expand" -- picks this widget up automatically and the "give the chart whatever space is left over" behavior propagates up through the widget tree with no manual `expandVertically()` calls needed on any wrapping container.

## Synopsis

`final class ChartWidget extends AbstractWidget implements VerticallyExpandableInterface`

|  |  |
|---|---|
| Extends | `AbstractWidget` |
| Implements | `VerticallyExpandableInterface` |
| Source | `ChartWidget.php` |

## Constructor

### __construct()

`public function __construct(array<float> $values = []): mixed`

| Parameter | Type | Description |
|---|---|---|
| `$values` | `array``<``float``>` |  |

Returns `mixed`

## Methods

| Method | Description |
|---|---|
| [`expandVertically(bool $expand): static`](#expandvertically) | Sets whether the chart claims the leftover vertical space of its container, invalidating the widget so the next frame re-lays it out. |
| [`isVerticallyExpanded(): bool`](#isverticallyexpanded) | Whether the chart currently claims leftover vertical space; ancestor containers consult this to propagate expansion up the widget tree. |
| [`render(RenderContext $context): array`](#render) | Draws the current values as a bar chart filling the assigned area. |
| [`setValues(array<float> $values): static`](#setvalues) |  |

### expandVertically()

`public function expandVertically(bool $expand): static`

Sets whether the chart claims the leftover vertical space of its container, invalidating the widget so the next frame re-lays it out.

Enabled by default.

| Parameter | Type | Description |
|---|---|---|
| `$expand` | `bool` |  |

Returns `static`

### isVerticallyExpanded()

`public function isVerticallyExpanded(): bool`

Whether the chart currently claims leftover vertical space; ancestor containers consult this to propagate expansion up the widget tree.

Returns `bool`

### render()

`public function render(RenderContext $context): array`

Draws the current values as a bar chart filling the assigned area.

Reads the row and column counts from $context on every frame — each floored at 1 — and resamples the series to that width before drawing, so a terminal resize is picked up without any explicit reconfiguration.

| Parameter | Type | Description |
|---|---|---|
| `$context` | `RenderContext` |  |

Returns `array`

### setValues()

`public function setValues(array<float> $values): static`

@return $this

| Parameter | Type | Description |
|---|---|---|
| `$values` | `array``<``float``>` | @return $this |

Returns `static`

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `addStyleClass()` | `AbstractWidget` |  |
| `beforeRender()` | `AbstractWidget` | Lifecycle hook: override to sync state before rendering. |
| `collectTerminalCleanupSequence()` | `AbstractWidget` | Collect and return an escape sequence the terminal must process when this widget is removed from the tree, and reset the associated state. |
| `findById()` | `AbstractWidget` | Find a descendant widget by ID (depth-first search). |
| `getContext()` | `AbstractWidget` |  |
| `getId()` | `AbstractWidget` |  |
| `getLabel()` | `AbstractWidget` |  |
| `getParent()` | `AbstractWidget` |  |
| `getRenderRevision()` | `AbstractWidget` |  |
| `getStateFlags()` | `AbstractWidget` |  |
| `getStyle()` | `AbstractWidget` |  |
| `getStyleClasses()` | `AbstractWidget` |  |
| `hasListeners()` | `AbstractWidget` | Check if this widget has any local listeners for the given event type. |
| `invalidate()` | `AbstractWidget` |  |
| `on()` | `AbstractWidget` | Register a listener for a specific event type on this widget. |
| `removeStyleClass()` | `AbstractWidget` |  |
| `setId()` | `AbstractWidget` |  |
| `setLabel()` | `AbstractWidget` | Set an optional human-readable label for the widget. |
| `setStyle()` | `AbstractWidget` |  |
| `setStyleClasses()` | `AbstractWidget` |  |
