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
  public function isValid(object $json, ?string $schema = NULL): bool {
    if (is_null($schema)) {
      // Try to get schema referenz from JSON input.
      if (isset($json->{'$schema'})) {
        $schema = $json->{'$schema'};
      }
      else {
        // No schema set, JSON is always valid.
        return TRUE;
      }
    }

    if (!filter_var($schema, FILTER_VALIDATE_URL)) {
      $schema = realpath($schema) === FALSE ? NULL : realpath($schema);
    }

    $validator = new Validator();
    $validator->validate($json, (object) ['$ref' => $schema]);

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

      throw new SchemaValidationException($schema, $errors);
    }

    return TRUE;
  }

}
