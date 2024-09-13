<?php

namespace SchemaValidator\Attribute;

/**
 * Defines a new attribute used for command tests.
 */
#[\Attribute()]
class CommandTest extends AttributeBase {

  /**
   * Name of command.
   *
   * @var string
   */
  public string $name;

  /**
   * List of arguments to apply to the command additionally to the default.
   *
   * @var array<string, string>
   */
  public array $arguments;

  /**
   * Creates a new CommandTest attribute object.
   *
   * @param string $name
   *   Name of the command.
   * @param array<string, string> $arguments
   *   List of arguments additional to the default arguments.
   *
   * @codeCoverageIgnore
   */
  public function __construct(string $name, array $arguments = []) {
    $this->name = $name;
    $this->arguments = $arguments;
  }

}
