<?php

namespace SchemaValidator\Tests\Kernel;

use SchemaValidator\Attribute\AttributeReaderTrait;
use SchemaValidator\Attribute\ServiceTest;
use SchemaValidator\ServiceInterface;
use SchemaValidator\Tests\Traits\FileSystemTrait;

/**
 * Base class for service tests.
 */
abstract class ServiceTestBase extends KernelTestBase {

  use AttributeReaderTrait;
  use FileSystemTrait;

  /**
   * The service to test.
   *
   * @var \SchemaValidator\ServiceInterface
   */
  protected ServiceInterface $service;

  /**
   * {@inheritdoc}
   */
  #[\Override]
  protected function setUp(): void {
    self::bootKernel();

    // Get all arguments from attribute "#[ServiceTest]".
    $arguments = static::readAttributeArguments(ServiceTest::class);

    $kernel = self::$kernel;
    assert(!is_null($kernel));

    // Initialize the virtual file system.
    $this->initFileSystem();

    // Make sure, we've got a service name to load.
    /** @var string|null $service_name */
    $service_name = $arguments['name'];

    assert(!is_null($service_name));
    /** @var \SchemaValidator\ServiceInterface $service_loaded */
    $service_loaded = self::getContainer()->get($service_name);
    $this->service = $service_loaded;
  }

}
