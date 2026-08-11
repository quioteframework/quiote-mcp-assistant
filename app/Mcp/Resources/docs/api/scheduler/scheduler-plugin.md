# SchedulerPlugin

> Registers the scheduler subsystem: a default no-op Schedule (so an app with nothing configured just runs zero tasks instead of erroring), the SchedulerLock service, and `schedule:run`.

Registers the scheduler subsystem: a default no-op [`Schedule`](/api/scheduler/schedule/) (so an app with nothing configured just runs zero tasks instead of erroring), the [`SchedulerLock`](/api/scheduler/scheduler-lock/) service, and `schedule:run`.

An app overrides [`Schedule`](/api/scheduler/schedule/) by binding its own subclass in `Config/factories.xml`.

## Synopsis

`final class SchedulerPlugin implements PluginInterface`

|  |  |
|---|---|
| Implements | [`PluginInterface`](/api/plugin/plugin-interface/) |
| Source | `SchedulerPlugin.php` |

## Methods

| Method | Description |
|---|---|
| [`register(PluginRegistrar $registrar): void`](#register) | Registers the scheduler's services and console command. |

### register()

`public function register(PluginRegistrar $registrar): void`

Registers the scheduler's services and console command.

Binds [`Schedule`](/api/scheduler/schedule/) as a singleton to an anonymous subclass that defines no tasks, so an app that has not bound its own schedule runs nothing instead of failing; binds [`SchedulerLock`](/api/scheduler/scheduler-lock/) as a singleton over the configured cache; and registers `schedule:run`.

| Parameter | Type | Description |
|---|---|---|
| `$registrar` | [`PluginRegistrar`](/api/plugin/plugin-registrar/) |  |
