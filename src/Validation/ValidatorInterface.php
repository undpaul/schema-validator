<?php

namespace SchemaValidator\Validation;

/**
 * Interface for validator classes.
 */
interface ValidatorInterface {

  /**
   * Check if the given JSON content is valid.
   *
   * @param object $json
   *   Decoded JSON content to validate.
   * @param string|null $schema
   *   Path to JSON schema or NULL if the schema should be autodetected.
   *
   * @return bool
   *   <code>TRUE</code> if the JSON content is valid.
   *
   * @throws \SchemaValidator\Exception\SchemaValidationException
   *   In case the JSON content does not validate against the schema.
   */
  public function isValid(object $json, ?string $schema = NULL): bool;

}
