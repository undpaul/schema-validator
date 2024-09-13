<?php

namespace SchemaValidator\Validation;

use JsonSchema\Validator;
use SchemaValidator\Exception\SchemaValidationException;

/**
 * Implements the JsonValidator.
 */
class JsonValidator implements ValidatorInterface {

  /**
   * {@inheritdoc}
   */
  #[\Override]
  public function isValid(object $json, ?string $schema = NULL, bool $throw_exception_on_error = TRUE): bool|\Exception {
    if (is_null($schema)) {
      // Try to get schema reference from JSON input.
      if (isset($json->{'$schema'})) {
        $schema = $json->{'$schema'};
      }
      else {
        // No schema set, JSON is always valid.
        return TRUE;
      }
    }

    if (!filter_var($schema, FILTER_VALIDATE_URL)) {
      // @codeCoverageIgnoreStart
      $schema = realpath($schema) === FALSE ? NULL : realpath($schema);
      // @codeCoverageIgnoreEnd
    }

    $validator = new Validator();
    $validator->validate($json, (object) ['$ref' => $schema]);

    $exception = FALSE;

    if (!$validator->isValid()) {
      $errors = [];
      foreach ($validator->getErrors() as $error) {
        /** @var string $property */
        $property = $error['property'];
        /** @var string $message */
        $message = $error['message'] ?? '';
        $errors[] = [
          $property => $message,
        ];
      }

      $exception = new SchemaValidationException($schema, $errors);
    }

    if (($throw_exception_on_error === TRUE) && ($exception !== FALSE)) {
      throw $exception;
    }

    return (($exception !== FALSE) && ($throw_exception_on_error === FALSE)) ? $exception : TRUE;
  }

}
