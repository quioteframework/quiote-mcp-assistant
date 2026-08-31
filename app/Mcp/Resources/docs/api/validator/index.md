# Validator

> The Quiote\\Validator namespace — 49 documented types.

Everything under `Quiote\Validator`.

## Classes

| Class | Description |
|---|---|
| [`AndoperatorValidator`](/api/validator/andoperator-validator/) | ANDOperatorValidator only succeeds if all sub-validators succeeded Parameters: 'skip_errors' do not submit errors of child validators to validator manager 'break' break the execution of child validators after first failure |
| [`ArraylengthValidator`](/api/validator/arraylength-validator/) | ArraylengthValidator verifies the length (count()) constraints for an array Parameters: 'min' The array should contain at least 'min' elements 'max' The array should contain at most 'max' elements |
| [`BaseFileValidator`](/api/validator/base-file-validator/) | BaseFileValidator is the base validator when validating files. |
| [`BooleanValidator`](/api/validator/boolean-validator/) | BooleanValidator verifies a parameter is a valid boolean Accepted values are string 0/1, int 0/1, bool true/false, string yes/no, string true/false, string on/off - basically all values that [`Toolkit::literalize()`](/api/util/toolkit/#literalize) will accept. |
| [`DateTimeValidator`](/api/validator/date-time-validator/) | DateTimeValidator verifies that a parameter is of a date and/or time format using native \DateTimeImmutable and IntlDateFormatter APIs. |
| [`DependencyManager`](/api/validator/dependency-manager/) | DependencyManager handles the dependencies in the validation process |
| [`EmailValidator`](/api/validator/email-validator/) | EmailValidator verifies if a parameter contains a value that qualifies as an email address. |
| [`EqualsValidator`](/api/validator/equals-validator/) | EqualsValidator verifies if a parameter equals to a given value The input is compared to a value and the validator fails if they differ. |
| [`FileValidator`](/api/validator/file-validator/) | FileValidator verifies the size and extension of a file |
| [`ImageFileValidator`](/api/validator/image-file-validator/) | ImageFileValidator verifies a parameter is an uploaded image Parameters: 'min_width' The minimum width of the image 'max_width' The maximum width of the image 'min_height' The minimum height of the image 'max_height' The maximum height of the image 'format' list of valid formats (gif,jpeg,png,bmp,psd,swf) Errors: 'no_image' The uploaded file is no image 'min_width' 'max_width' 'min_height' 'max_height' 'format' The image was not in the required format |
| [`InarrayValidator`](/api/validator/inarray-validator/) | InArrayValidator verifies whether an input is one of a set of values Parameters: 'values' list of values that form the array 'sep' separator of values in the list 'case' verifies case sensitive if true 'strict' whether or not to do strict type comparisons with in_array() |
| [`IsNotEmptyValidator`](/api/validator/is-not-empty-validator/) | IsNotEmptyValidator verifies a parameter is not empty The content of the input value is not verified in any manner, it is only checked if the input value exists and is not empty. |
| [`IssetValidator`](/api/validator/isset-validator/) | IssetValidator verifies a parameter is set The content of the input value is not verified in any manner, it is only checked if the input value exists. |
| [`JsonValidator`](/api/validator/json-validator/) | JsonValidator verifies if a parameter contains a value that is valid JSON. |
| [`NotoperatorValidator`](/api/validator/notoperator-validator/) | NOTOperatorValidator succeeds if the sub-validator failed Parameters: 'skip_errors' do not submit errors of child validators to validator manager |
| [`NumberValidator`](/api/validator/number-validator/) | NumberValidator verifies that a parameter is a number and allows you to apply size constraints. |
| [`OperatorValidator`](/api/validator/operator-validator/) | OperatorValidator Operators group a couple if validators... |
| [`OroperatorValidator`](/api/validator/oroperator-validator/) | OROperatorValidator succeeds if at least one sub-validators succeeded Parameters: 'skip_errors' do not submit errors of child validators to validator manager 'break' break the execution of child validators after first success |
| [`RegexValidator`](/api/validator/regex-validator/) | RegexValidator allows you to match a value against a regular expression pattern. |
| [`SetValidator`](/api/validator/set-validator/) | SetValidator only exports a value and always succeeds Parameters: 'value' value that should be exported |
| [`StringValidator`](/api/validator/string-validator/) | StringValidator allows you to apply string-related constraints to a parameter. |
| [`ValidationArgument`](/api/validator/validation-argument/) | ValidationArgument is a tuple of argument name and source that specifies the argument to validate. |
| [`ValidationError`](/api/validator/validation-error/) | ValidationError stores an error message and the fields of an error. |
| [`ValidationIncident`](/api/validator/validation-incident/) | ValidationIncident is erroneous result of an validation run. |
| [`ValidationManager`](/api/validator/validation-manager/) | ValidationManager provides management for request parameters and their associated validators. |
| [`ValidationReport`](/api/validator/validation-report/) | ValidationReport stores the result of a validation run. |
| [`ValidationReportQuery`](/api/validator/validation-report-query/) | ValidationReportQuery allows queries against the validation run report. |
| [`Validator`](/api/validator/validator/) | Validator allows you to validate input Parameters for use in most validators: 'name' name of validator 'base' base path for validation of arrays 'arguments' an array of input parameter keys to validate 'export' destination for exported data 'depends' list of dependencies needed by the validator 'provides' list of dependencies the validator provides after success 'severity' error severity in case of failure 'error' error message when validation fails 'errors' an array of errors with the reason as key 'required' if true the validator will fail when the input parameter is not set |
| [`ValidatorFactory`](/api/validator/validator-factory/) | Builds a validator from its class name. |
| [`XoroperatorValidator`](/api/validator/xoroperator-validator/) | XOROperatorValidator succeeds if only one of two sub-validators succeeded Parameters: 'skip_errors' don't submit errors of child validators to validator manager |

## Interfaces

| Interface | Description |
|---|---|
| [`IValidationReportQuery`](/api/validator/i-validation-report-query/) | IValidationReportQuery allows queries against the validation run report. |
| [`IValidatorContainer`](/api/validator/i-validator-container/) | IValidatorContainer is an interface for classes which contains several child validators |
| [`ValidatorInterface`](/api/validator/validator-interface/) | What a validator container asks of a validator: configure it, run it against a request, and read back what it named, decided and exported. |

## Nested namespaces

| Namespace | Contents |
|---|---|
| [`Compiler`](/api/validator/compiler/) | 16 types |
