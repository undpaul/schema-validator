<?php

namespace SchemaValidator\Attribute;

/**
 * Base attribute.
 *
 * @codeCoverageIgnore
 */
abstract class AttributeBase implements AttributeInterface {

  /**
   * The class used for this attribute class.
   *
   * @var class-string
   */
  protected string $class;

  /**
   * Constructs an attribute object.
   *
   * @param string $id
   *   The attribute class ID.
   *
   * @codeCoverageIgnore
   */
  public function __construct(
    public readonly string $id,
  ) {
    // Nothing to do here.
  }

  /**
   * {@inheritdoc}
   */
  #[\Override]
  public function getId(): string {
    return $this->id;
  }

  /**
   * {@inheritdoc}
   */
  #[\Override]
  public function get(): mixed {
    $variables = get_object_vars($this) + [
      'class' => $this->getClass(),
    ];

    return array_filter($variables, function ($value) {
      return $value !== NULL;
    }, ARRAY_FILTER_USE_BOTH);
  }

  /**
   * {@inheritdoc}
   */
  #[\Override]
  public function getClass(): string {
    return $this->class;
  }

  /**
   * {@inheritdoc}
   */
  #[\Override]
  public function setClass(string $class): void {
    $this->class = $class;
  }

}
