# Scan

> The Quiote\\Docs\\Scan namespace — 3 documented types.

Everything under `Quiote\Docs\Scan`.

## Classes

| Class | Description |
|---|---|
| [`FileTokenReader`](/api/docs/scan/file-token-reader/) | Reads a PHP file's namespace, first class-like declaration and `use` imports straight from its tokens, without executing or autoloading anything. |
| [`ScannedType`](/api/docs/scan/scanned-type/) | One class-like declaration, as read out of its source file by the tokenizer. |
| [`SourceScanner`](/api/docs/scan/source-scanner/) | Finds every documentable class-like in the framework by walking Composer's PSR-4 prefix map and reading each file's own declaration. |
