# Console

> The Quiote\\Scheduler\\Console namespace — 1 documented type.

Everything under `Quiote\Scheduler\Console`.

## Classes

| Class | Description |
|---|---|
| [`ScheduleRunCommand`](/api/scheduler/console/schedule-run-command/) | Evaluates every task in the app's [`Schedule`](/api/scheduler/schedule/) against "now" and runs the due ones once, then exits — this is meant to be invoked by the OS's own crontab (`* * * * * php bin/quiote schedule:run`) every minute, like every cron-based scheduler, not a long-running daemon loop. |
