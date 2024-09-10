<?php

namespace SchemaValidator\Exception;

/**
 * Interface for context aware exceptions.
 */
interface ContextAwareExceptionInterface {

  /**
   * Set additional data to the exception.
   *
   * @param array<string, mixed> $context
   *   Additional data useful to handle the exception.
   *
   * @return static
   *   The current exception for method chaining.
   */
  public function setContext(array $context): static;

  /**
   * Get extra data for the exception.
   *
   * @return array<string, mixed>
   *   Additional data useful to handle the exception.
   */
  public function getContext(): array;

}
