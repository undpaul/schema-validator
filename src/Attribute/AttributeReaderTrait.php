<?php

namespace SchemaValidator\Attribute;

/**
 * Read PHP attributes.
 */
trait AttributeReaderTrait {

  /**
   * Read all arguments from a PHP attribute.
   *
   * @param string $name
   *   Name of attribute to read arguments from.
   *
   * @return array<string, mixed>
   *   List of attribute arguments.
   */
  protected static function readAttributeArguments(string $name): array {
    $reflection = new \ReflectionClass(static::class);
    /** @var \ReflectionAttribute[] $attributes */
    // @phpstan-ignore-next-line
    $attributes = $reflection->getAttributes($name);

    if (count($attributes) === 0) {
      return [];
    }

    // We are interested in the first instance of the attribute only.
    /** @var \ReflectionAttribute $attribute */
    // @phpstan-ignore-next-line
    $attribute = reset($attributes);
    return $attribute->getArguments();
  }

}
