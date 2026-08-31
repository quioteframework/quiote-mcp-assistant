# ResolvesCassetteStore

> Resolves whichever CassetteStoreInterface `replay.store` actually names, via the app's own DI container -- the same seam `Quiote\\Replay\\Recording\\RecorderMiddleware`'s factory already resolves it through (`ReplayPlugin::register()`'s `attributedMiddleware` closure).

Resolves whichever [`CassetteStoreInterface`](/api/replay/store/cassette-store-interface/) `replay.store` actually names, via the app's own DI container -- the same seam `Quiote\Replay\Recording\RecorderMiddleware`'s factory already resolves it through (`ReplayPlugin::register()`'s `attributedMiddleware` closure).

Before this, `cassette:list`/`cassette:show`/`replay` each hardcoded a `new FileCassetteStore(...)` and refused to run at all when `replay.store` named anything else -- correct as far as it went (no other store existed yet), but the console surface was never actually store-agnostic, and a genuinely non-file store (`quioteframework/replay-pdo`) would have had no way to make these commands work at all.

Resolved against `core.default_context`, not a per-command `--context` option: `replay.store`/`replay.store.*` are global app config, not per-context, so any bootable context resolves the identical configured store. `ReplayCommand`'s own `--context` option is a separate concern -- which context to *replay a request against* -- and is left untouched.

## Synopsis

`trait ResolvesCassetteStore`

|  |  |
|---|---|
| Source | `Console/ResolvesCassetteStore.php` |
