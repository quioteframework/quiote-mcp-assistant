# Index

> The Quiote\\Replay\\Store\\Azure\\Index namespace — 1 documented type.

Everything under `Quiote\Replay\Store\Azure\Index`.

## Classes

| Class | Description |
|---|---|
| [`LogAnalyticsIndex`](/api/replay/store/azure/index/log-analytics-index/) | Upgrades resolution from "an id plus a date/hour hint" to a bare id with nothing else: queries the workspace for the pointer log line the recorder itself wrote, reads its `cassette_key` straight off that record, and fetches the object at that key. |
