<?php

namespace SchemaValidator\Attribute;

/**
 * Defines a new attribute used for service tests.
 */
#[\Attribute]
class ServiceTest extends AttributeBase {

  /**
   * Name of service to load.
   *
   * @var string
   */
  public string $name;

  /**
   * List of arguments to apply to the command additionally to the default.
   *
   * @var array<string, string>
   */
  public array $additionalServices;

  /**
   * Creates a new CommandTest attribute object.
   *
   * @param string $name
   *   Name of the command.
   * @param array<string> $services
   *   List of additional services to load.
   *
   * @codeCoverageIgnore
   */
  public function __construct(string $name, array $services = []) {
    $this->name = $name;
    $this->additionalServices = $services;
  }

}
