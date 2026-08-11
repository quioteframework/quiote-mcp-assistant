# DirectiveExpander

> Applies the same %core.quiote_dir%-style directive expansion and literal-boolean coercion that XML config values get \"for free\" via XmlConfigDomElement::getLiteralValue() (which runs Toolkit::literalize() on element text by default) -- to PHP-array and YAML config values, which have no XML text-node equivalent to hook that into.

Applies the same %core.quiote_dir%-style directive expansion and literal-boolean coercion that XML config values get "for free" via XmlConfigDomElement::getLiteralValue() (which runs Toolkit::literalize() on element text by default) -- to PHP-array and YAML config values, which have no XML text-node equivalent to hook that into.

Without this, a YAML/PHP config author would have to write `Config::getString('core.quiote_dir') . '/foo'` themselves instead of the `%core.quiote_dir%/foo` string every existing XML config already uses, which would make migrating a config file from XML a breaking change in its own right rather than a drop-in format swap.

## Synopsis

`final class DirectiveExpander`

|  |  |
|---|---|
| Since | `1.0.0` |
| Source | `Config/Format/DirectiveExpander.php` |

## Methods

| Method | Description |
|---|---|
| [`expand(array<TKey, mixed> $config): array<TKey, mixed>`](#expand) | Recursively expands every string leaf in $config via Toolkit::literalize() (directive expansion + "true"/"false"/"yes"/ "no"/etc. |

### expand()

`public function expand(array<TKey, mixed> $config): array<TKey, mixed>`

Recursively expands every string leaf in $config via Toolkit::literalize() (directive expansion + "true"/"false"/"yes"/ "no"/etc.

| Parameter | Type | Description |
|---|---|---|
| `$config` | `array``<``TKey``, ``mixed``>` |  |

Returns `array``<``TKey``, ``mixed``>` — A new array; $config is not mutated.
