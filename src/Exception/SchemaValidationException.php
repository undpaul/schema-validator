<?php

namespace SchemaValidator\Exception;

/**
 * Defines the SchemaValidationException.
 */
class SchemaValidationException extends ContextAwareException {

  /**
   * Creates a new SchemaValidationException.
   *
   * @param string $schema
   *   Path to JSON schema.
   * @param array<array<string, string>> $errors
   *   List of validation errors.
   */
  public function __construct(string $schema, array $errors) {
    $message = strtr('The given JSON content does not validate against schema "!schema".', ['!schema' => $schema]) . PHP_EOL;

    // Add errors to message.
    $message .= implode("\n", array_map(fn($item) => key($item) . ': ' . current($item), $errors));

    parent::__construct($message);
  }

}
