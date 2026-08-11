# Doctrine

> The Quiote\\Database\\Adapter\\Doctrine namespace — 4 documented types.

Everything under `Quiote\Database\Adapter\Doctrine`.

## Classes

| Class | Description |
|---|---|
| [`DoctrineDatabase`](/api/database/adapter/doctrine/doctrine-database/) | Modern first-class adapter for Doctrine ORM 3 / DBAL 4. |
| [`DoctrineDbalDatabase`](/api/database/adapter/doctrine/doctrine-dbal-database/) | Tier-2 adapter: a Doctrine DBAL connection (connection abstraction + query builder) without the ORM/entity layer. |
| [`DoctrinePlugin`](/api/database/adapter/doctrine/doctrine-plugin/) | Enables the `doctrine` (ORM) and `doctrine_dbal` (DBAL-only) driver aliases. |

## Traits

| Trait | Description |
|---|---|
| [`DoctrineDbalParams`](/api/database/adapter/doctrine/doctrine-dbal-params/) | Shared translation of flat `databases.xml` parameters into a Doctrine DBAL connection-parameters array, used by both [`DoctrineDatabase`](/api/database/adapter/doctrine/doctrine-database/) and [`DoctrineDbalDatabase`](/api/database/adapter/doctrine/doctrine-dbal-database/). |
