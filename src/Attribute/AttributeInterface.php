<?php

namespace SchemaValidator\Attribute;

/**
 * Defines a common interface for classed attributes.
 */
interface AttributeInterface {

  /**
   * Get the unique attribute id.
   *
   * @return string
   *   The unique attribute id.
   */
  public function getId(): string;

  /**
   * Gets the value of an attribute.
   *
   * @return mixed
   *   The attribute definition.
   */
  public function get(): mixed;

  /**
   * Gets the class of the attribute class.
   *
   * @return class-string|null
   *   The class name or <code>NULL</code> if it isn't set.
   */
  public function getClass(): ?string;

  /**
   * Sets the class of the attributed class.
   *
   * @param class-string $class
   *   The class of the attributed class.
   */
  public function setClass(string $class): void;

}
