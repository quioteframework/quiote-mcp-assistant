# IModel

> Model provides a convention for separating business logic from application logic.

Model provides a convention for separating business logic from application logic.

When using a model you're providing a globally accessible API for other modules to access, which will boost interoperability among modules in your web application.

## Synopsis

`interface IModel`

|  |  |
|---|---|
| Implemented by | [`ISingletonModel`](/api/model/i-singleton-model/), [`Model`](/api/model/model/) |
| Since | `1.0.0` |
| Source | `Model/IModel.php` |

## Methods

| Method | Description |
|---|---|
| [`getContext(): Context`](#getcontext) |  |

### getContext()

`abstract public function getContext(): Context`

Returns [`Context`](/api/context/)
