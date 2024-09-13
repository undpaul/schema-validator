<?php

namespace SchemaValidator\Exception;

/**
 * Defines a ContextAwareException.
 */
abstract class ContextAwareException extends \Exception implements ContextAwareExceptionInterface {

  /**
   * The exception context.
   *
   * @var array<string, mixed>
   */
  protected array $context;

  /**
   * {@inheritdoc}
   */
  #[\Override]
  public function addContext(string $name, mixed $value): static {
    $this->context[$name] = $value;

    return $this;
  }

  /**
   * {@inheritdoc}
   */
  #[\Override]
  public function setContext(array $context): static {
    $this->context = $context;

    return $this;
  }

  /**
   * {@inheritdoc}
   */
  #[\Override]
  public function getContext(): array {
    return $this->context;
  }

}
