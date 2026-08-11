# FormPopulation

> The Quiote\\Util\\FormPopulation namespace — 10 documented types.

Everything under `Quiote\Util\FormPopulation`.

## Classes

| Class | Description |
|---|---|
| [`DocumentEncoding`](/api/util/form-population/document-encoding/) | The character encoding a document is being populated in, and the conversions between it and UTF-8. |
| [`DocumentLoader`](/api/util/form-population/document-loader/) | Parses a response body into a DOM, deciding as it goes whether the document is XHTML and how strictly to read it. |
| [`DocumentSerializer`](/api/util/form-population/document-serializer/) | Turns the populated DOM back into the response body. |
| [`FieldErrorDecorator`](/api/util/form-population/field-error-decorator/) | Marks a field that failed validation, by putting the configured error class on it and on whatever else the error class map points at. |
| [`FieldNameResolver`](/api/util/form-population/field-name-resolver/) | Turns an element's `name` attribute into the parameter path its value lives under, resolving the empty brackets HTML uses for repeated fields. |
| [`FieldValueApplier`](/api/util/form-population/field-value-applier/) | Writes a submitted value onto the form element that carries it. |
| [`FormFinder`](/api/util/form-population/form-finder/) | Decides which forms in the document get populated, and from what. |
| [`ParsedDocument`](/api/util/form-population/parsed-document/) | A response body parsed into a DOM, with the decisions the parse made. |
| [`ResolvedFieldName`](/api/util/form-population/resolved-field-name/) | A form element's name, resolved to the parameter path its value lives under. |
| [`SkipList`](/api/util/form-population/skip-list/) | The fields configured to be left exactly as the view rendered them. |
