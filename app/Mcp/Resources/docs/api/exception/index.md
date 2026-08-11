# Exception

> The Quiote\\Exception namespace — 27 documented types.

Everything under `Quiote\Exception`.

## Classes

| Class | Description |
|---|---|
| [`CacheException`](/api/exception/cache-exception/) | CacheException is thrown when ConfigCache fails to execute properly. |
| [`ClassNotFoundException`](/api/exception/class-not-found-exception/) | ClassNotFoundException is thrown when a class could not be found. |
| [`ConfigurationException`](/api/exception/configuration-exception/) | ConfigurationException is thrown when the framework finds an error in a configuration setting. |
| [`ControllerException`](/api/exception/controller-exception/) | ControllerException is thrown when a requested Controller implementation doesn't exist. |
| [`DatabaseException`](/api/exception/database-exception/) | DatabaseException is thrown when a database related error occurs. |
| [`DisabledModuleException`](/api/exception/disabled-module-exception/) | DisabledModuleException is thrown when Controller::initializeModule gets called on a disabled module |
| [`FactoryException`](/api/exception/factory-exception/) | FactoryException is thrown when an error occurs while attempting to create a new factory implementation instance. |
| [`FileException`](/api/exception/file-exception/) | FileException is thrown when an error occurs while moving an uploaded file. |
| [`FileNotFoundException`](/api/exception/file-not-found-exception/) | FileNotFoundException is thrown when a file could not be found. |
| [`InitializationException`](/api/exception/initialization-exception/) | InitializationException is thrown when an initialization procedure fails. |
| [`LoggingException`](/api/exception/logging-exception/) | LoggingException is thrown when a logging related error occurs. |
| [`ParseException`](/api/exception/parse-exception/) | ParseException is thrown when a parsing procedure fails to complete successfully. |
| [`QuioteException`](/api/exception/quiote-exception/) | QuioteException is the base class for all Quiote related exceptions. |
| [`RenderException`](/api/exception/render-exception/) | RenderException is thrown when a view's pre-render check fails. |
| [`SecurityException`](/api/exception/security-exception/) | SecurityException is thrown when a security related error occurs. |
| [`StorageException`](/api/exception/storage-exception/) | StorageException is thrown when a requested Storage implementation doesn't exist or data cannot be read from or written to the storage. |
| [`UncacheableException`](/api/exception/uncacheable-exception/) | UncacheableException can be thrown by cache group callbacks to signal to the framework's execution filter that no caching should occur. |
| [`UnreadableException`](/api/exception/unreadable-exception/) | UnreadableException is thrown when a configuration file could not be found or is unreadable. |
| [`UnvalidatedParameterAccessException`](/api/exception/unvalidated-parameter-access-exception/) | Raised by [`WebRequest::getParameter()`](/api/request/web-request/#getparameter) when a parameter that no validator declared is read without a default. |
| [`ValidatorException`](/api/exception/validator-exception/) | ValidatorException is thrown when an error occurs in a validator. |
| [`ViewException`](/api/exception/view-exception/) | ViewException is thrown when an error occurs in a view. |

## Nested namespaces

| Namespace | Contents |
|---|---|
| [`Rendering`](/api/exception/rendering/) | 6 types |
