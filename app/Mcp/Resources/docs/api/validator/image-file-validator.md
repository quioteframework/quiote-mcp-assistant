# ImageFileValidator

> ImageFileValidator verifies a parameter is an uploaded image Parameters: 'min_width' The minimum width of the image 'max_width' The maximum width of the image 'min_height' The minimum height of the image 'max_height' The maximum height of the image 'format' list of valid formats (gif,jpeg,png,bmp,psd,swf) Errors: 'no_image' The uploaded file is no image 'min_width' 'max_width' 'min_height' 'max_height' 'format' The image was not in the required format

ImageFileValidator verifies a parameter is an uploaded image Parameters: 'min_width'    The minimum width of the image 'max_width'    The maximum width of the image 'min_height'   The minimum height of the image 'max_height'   The maximum height of the image 'format'       list of valid formats (gif,jpeg,png,bmp,psd,swf) Errors: 'no_image'      The uploaded file is no image 'min_width' 'max_width' 'min_height' 'max_height' 'format'        The image was not in the required format

## Synopsis

`class ImageFileValidator extends BaseFileValidator`

|  |  |
|---|---|
| Extends | [`BaseFileValidator`](/api/validator/base-file-validator/) |
| Since | `1.0.0` |
| Source | `Validator/ImageFileValidator.php` |

## Methods

| Method | Description |
|---|---|
| [`getAcceptedParameters(): array<int, string>`](#getacceptedparameters) | Returns the file-validator parameters plus 'min_width', 'max_width', 'min_height', 'max_height' and 'format'. |

### getAcceptedParameters()

`public static function getAcceptedParameters(): array<int, string>`

Returns the file-validator parameters plus 'min_width', 'max_width', 'min_height', 'max_height' and 'format'.

The four dimension parameters bound the pixel size read out of the uploaded image itself, each checked only when present. 'format' is a list of acceptable image formats, given either as an array or as a space-delimited string and matched case-insensitively against the extension for the detected image type, with 'jpg' and 'tif' accepted alongside the 'jpeg' and 'tiff' PHP reports. The size, extension and MIME parameters inherited from BaseFileValidator apply as well.

Returns `array``<``int``, ``string``>` — The accepted parameter names.

## Inherited methods

These come from an ancestor and are documented where they are declared.

| Method | Declared in | Description |
|---|---|---|
| `appendParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter. |
| `appendParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Append a parameter by reference. |
| `clearParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Clear all parameters associated with this request. |
| `execute()` | [`Validator`](/api/validator/validator/) | Executes the validator. |
| `getArguments()` | [`Validator`](/api/validator/validator/) | Returns all arguments which should be validated. |
| `getBase()` | [`Validator`](/api/validator/validator/) | Returns the base path of this validator. |
| `getBaseKeys()` | [`Validator`](/api/validator/validator/) | Returns the "keys" in the path of the base |
| `getContext()` | [`Validator`](/api/validator/validator/) | Retrieve the current application context. |
| `getDependencyManager()` | [`Validator`](/api/validator/validator/) | Returns the depency manager of the parent container if any. |
| `getFlatParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of flattened parameter names. |
| `getLastKey()` | [`Validator`](/api/validator/validator/) | Returns the last "keys" in the path of the base |
| `getMutatedRequest()` | [`Validator`](/api/validator/validator/) | The WebRequest this validator ended execute() with. |
| `getName()` | [`Validator`](/api/validator/validator/) | Returns the name of this validator. |
| `getParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve a parameter. |
| `getParameterNames()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameter names. |
| `getParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Retrieve an array of parameters. |
| `getParentContainer()` | [`Validator`](/api/validator/validator/) | Retrieve the parent container. |
| `hasParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Indicates whether or not a parameter exists. |
| `initialize()` | [`BaseFileValidator`](/api/validator/base-file-validator/) |  |
| `mapErrorCode()` | [`Validator`](/api/validator/validator/) | Converts string severity codes into integer values (see severity constants) critical -> Validator::CRITICAL error -> Validator::ERROR notice -> Validator::NOTICE none -> Validator::NONE success -> not allowed to be specified by the user. |
| `removeParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Remove a parameter. |
| `reset()` | [`Validator`](/api/validator/validator/) | Returns the validator to its uninitialized state for reuse across requests. |
| `setErrorMessage()` | [`Validator`](/api/validator/validator/) | Sets an error message override for the given index (the empty string is the default/generic message). |
| `setParameter()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter. |
| `setParameterByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set a parameter by reference. |
| `setParameters()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters. |
| `setParametersByRef()` | [`ParameterHolder`](/api/util/parameter-holder/) | Set an array of parameters by reference. |
| `setParentContainer()` | [`Validator`](/api/validator/validator/) | Sets the parent container. |
| `shutdown()` | [`Validator`](/api/validator/validator/) | Shuts the validator down. |
