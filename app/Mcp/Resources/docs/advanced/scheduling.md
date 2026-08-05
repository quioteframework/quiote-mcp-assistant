# Scheduled tasks

> Cron-expression task scheduling with quioteframework/scheduler — defining a Schedule, dispatching jobs or inline callbacks, overlap prevention, and the schedule:run command.

**[`quioteframework/scheduler`](/plugins/official-packages/#quioteframeworkscheduler)** adds cron-expression task scheduling: you declare *what* runs and *when* in one PHP class, and the OS's crontab runs a single `schedule:run` command once a minute to execute whatever is due. Adding, moving or removing a scheduled task is a code change, not a crontab change.

It is layered on **[`quioteframework/queue`](/advanced/queues/)** — a scheduled task's default and recommended shape is "dispatch a job", so the actual work runs through whichever queue driver the app already has configured, with that package's retry and dead-letter handling.

```bash
composer require quioteframework/scheduler
```

## Defining a schedule

Subclass `Quiote\Scheduler\Schedule` and implement `define()`. Each `job()`/`call()` call returns a fluent definition you chain a cron spec onto:

```php
<?php
namespace App\Schedule;

use App\Job\RebuildSearchIndex;
use App\Job\SendDigestEmails;
use App\Service\SessionReaper;
use Quiote\DI\Container;
use Quiote\Scheduler\Schedule;

final class AppSchedule extends Schedule
{
    protected function define(): void
    {
        $this->job(SendDigestEmails::class)->dailyAt('06:00');
        $this->job(RebuildSearchIndex::class, ['full' => false])->cron('*/15 * * * *');
        $this->call(fn(Container $c) => $c->get(SessionReaper::class)->gc())->hourly()->withoutOverlapping();
    }
}
```

`define()` is called on every `schedule:run` invocation, so the definitions are always read fresh from code.

### Two kinds of task

| Builder | What runs | When to use it |
|---|---|---|
| `->job($jobClass, $params = [])` | Pushes a `Quiote\Queue\Job` onto `QueueManager` | The default. The work happens on the configured queue driver, with retries and dead-lettering. |
| `->call($closure)` | Runs the closure in-process, synchronously | Cheap, fast housekeeping that doesn't warrant a queue round-trip. |

`->job()` only *dispatches* — it does not wait for the job to run. With a persistent driver (`queue-db`, `queue-redis`) the job goes onto the backlog and a `queue:work` process picks it up; with the default `sync` driver it runs inline inside the `schedule:run` process, which means a slow job holds up the rest of that minute's tasks.

`->call()`'s closure receives the DI `Container` as its argument, so it can resolve services at run time rather than capturing them when the schedule is defined — as `SessionReaper` above does.

A `->call()` closure that throws is caught and reported by `schedule:run` (see [below](#running-the-scheduler)); it does not abort the rest of the run.

### Cron specs

| Method | Expression |
|---|---|
| `->cron('*/5 * * * *')` | Any standard five-field cron expression |
| `->everyMinute()` | `* * * * *` |
| `->hourly()` | `0 * * * *` |
| `->daily()` | `0 0 * * *` |
| `->dailyAt('06:30')` | `30 6 * * *` |

A task with no cron call at all defaults to `* * * * *` — every minute. Expressions are evaluated by [`dragonmantank/cron-expression`](https://github.com/dragonmantank/cron-expression), so the full syntax it supports (step values, ranges, lists, named months and weekdays) works.

### Preventing overlap

A task that sometimes takes longer than its own interval will otherwise be started again by the next `schedule:run` while the first is still going. Opt into a lock to prevent that:

```php
$this->call(fn() => $this->reindexEverything())->hourly()->withoutOverlapping(ttlSeconds: 7200);
```

While the lock is held, a due invocation is *skipped*, not queued — it will simply run at the next matching minute. The `$ttlSeconds` argument (default `3600`) is the lock's expiry, which is also the failsafe: if a process dies without releasing its lock, the task resumes after that long rather than being blocked forever. Set it comfortably above the task's worst-case runtime.

Lock keys are derived from the task's label and cron expression, so they're stable across separate `schedule:run` processes — which is what makes cross-invocation overlap detection work at all.

:::caution[`withoutOverlapping()` is best-effort, not a distributed lock]
`SchedulerLock` is built on the app's existing PSR-16 cache, and PSR-16 has no atomic add-if-absent operation. There is therefore a narrow race window between one invocation's `has()` check and its `set()` — two `schedule:run` processes starting in the same instant could both acquire. That is acceptable for what this actually guards against (a slow task still running when the next minute's invocation starts) and is **not** a guarantee you can build correctness on. If a task must never run twice concurrently under any circumstances, make the task itself idempotent or take a real lock inside it.
:::

## Registering your schedule

`SchedulerPlugin` registers a **default no-op `Schedule`**, so installing the package without defining anything is a safe no-op rather than an error — `schedule:run` reports `Ran 0` and exits 0. To use your own, bind your subclass as the `Schedule` service.

Plugin service contributions are applied **register-if-absent**, so the app's own binding wins as long as it is in place first. The straightforward way is a small app plugin declared *ahead* of `SchedulerPlugin`:

```php
<?php
namespace App\Plugin;

use App\Schedule\AppSchedule;
use Quiote\Plugin\Attribute\Plugin;
use Quiote\Plugin\PluginInterface;
use Quiote\Plugin\PluginRegistrar;
use Quiote\Scheduler\Schedule;

#[Plugin(name: 'app/schedule')]
final class AppSchedulePlugin implements PluginInterface
{
    public function register(PluginRegistrar $registrar): void
    {
        $registrar->service(Schedule::class, static fn() => new AppSchedule());
    }
}
```

The `#[Plugin]` attribute is **required** here, not decoration. Activating a plugin by class name — which is what the `Config/plugins.*` entry below does — goes through `PluginManager::instantiate()`, and a class without the attribute is refused: it logs an error and returns `null`, so `register()` never runs. The symptom is a schedule that silently stays the default no-op and a `schedule:run` that reports `Ran 0`. See [Plugins: `#[Plugin]` is mandatory for class-string activation](/architecture/plugins/#registering-a-plugin).

#### PHP

```php
// Config/plugins.php
return [
    ['class' => \Quiote\Queue\QueuePlugin::class, 'enabled' => true],
    ['class' => \App\Plugin\AppSchedulePlugin::class, 'enabled' => true],
    ['class' => \Quiote\Scheduler\SchedulerPlugin::class, 'enabled' => true],
];
```

#### YAML

```yaml
# Config/plugins.yaml
- class: Quiote\Queue\QueuePlugin
  enabled: true
- class: App\Plugin\AppSchedulePlugin
  enabled: true
- class: Quiote\Scheduler\SchedulerPlugin
  enabled: true
```

#### XML

```xml
<!-- Config/plugins.xml -->
<ae:configurations xmlns:ae="http://quiote.dev/quiote/config/global/envelope/1.1"
                    xmlns="http://quiote.dev/quiote/config/parts/plugins/1.1">
    <ae:configuration>
        <plugin class="Quiote\Queue\QueuePlugin" />
        <plugin class="App\Plugin\AppSchedulePlugin" />
        <plugin class="Quiote\Scheduler\SchedulerPlugin" />
    </ae:configuration>
</ae:configurations>
```

The ordering matters: whichever plugin contributes `Schedule` **first** wins, so your plugin must be declared before `SchedulerPlugin`'s no-op default. See [Plugins and extensibility](/architecture/plugins/) for the general rule.

`SchedulerPlugin` also registers `SchedulerLock` (wrapping `CacheManager::getCache()`) and the `schedule:run` command itself.

## Running the scheduler

Add **one** crontab line per app, regardless of how many tasks the schedule defines:

```text
* * * * * php /path/to/app/bin/quiote schedule:run --app-dir=/path/to/app >> /dev/null 2>&1
```

That's the whole deployment story. Everything else lives in `AppSchedule`.

`schedule:run` evaluates every task against "now", runs the due ones once, prints a summary, and exits:

```text
Skipped (already running): App\Job\RebuildSearchIndex (*/15 * * * *)
[OK] Ran 2, skipped 1 (locked), failed 0.
```

It exits non-zero if any task threw. A task that throws is caught, reported, and counted as failed — the remaining due tasks still run, because one bad task must not block the rest.

Like every other bootstrapped command it accepts `--app-dir` and `--env`; see [The command-line tool](/getting-started/cli/).

:::note[`schedule:run` is not a daemon]
It is designed to be invoked once a minute by the OS's own crontab, exactly like every other cron-based scheduler — it evaluates, runs, and exits. There is no long-running loop to supervise, nothing to restart on deploy, and no process to keep alive. Running it more or less often than once a minute changes cron's own granularity (a `* * * * *` task can only fire as often as `schedule:run` is invoked), not anything inside the framework.
:::
