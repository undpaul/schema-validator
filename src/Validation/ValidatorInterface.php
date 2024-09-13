<?php

namespace SchemaValidator\Validation;

use SchemaValidator\ServiceInterface;

/**
 * Interface for validator classes.
 */
interface ValidatorInterface extends ServiceInterface {

  /**
   * Check if the given JSON content is valid.
   *
   * @param object $json
   *   Decoded JSON content to validate.
   * @param string|null $schema
   *   Path to JSON schema or NULL if the schema should be autodetected.
   * @param bool $throw_exception_on_error
   *   Throw an exception on validation error. Defaults to <code>TRUE</code>.
   *
   * @return bool|\Exception
   *   <code>TRUE</code> if the JSON content is valid. If there is a validation
   *   error and <code>$throw_exception_on_error</code> is set to
   *   <code>FALSE</code>, the exception is returned and not thrown.
   *
   * @throws \SchemaValidator\Exception\SchemaValidationException
   *   In case the JSON content does not validate against the schema.
   */
  public function isValid(object $json, ?string $schema = NULL, bool $throw_exception_on_error = TRUE): bool|\Exception;

}
