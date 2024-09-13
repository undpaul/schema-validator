<?php

namespace SchemaValidator\Tests\Kernel\Attribute;

use SchemaValidator\Attribute\AttributeReaderTrait;
use SchemaValidator\Attribute\ServiceTest;
use SchemaValidator\Tests\Kernel\ServiceTestBase;

/**
 * Tests reading PHP attributes.
 */
#[ServiceTest(
  // Use the schema validation service though we don't test it here.
  name: 'schema_validator.validator',
)]
class AttributeReaderTraitTest extends ServiceTestBase {

  /**
   * Test reading PHP attribute arguments from a class.
   */
  public function testReadAttributeArguments(): void {
    $mock = new #[ServiceTest(name: 'test')] class {

      use AttributeReaderTrait;

    };

    // We need to use reflection because the method is protected.
    $class = new \ReflectionClass($mock);
    $method = $class->getMethod('readAttributeArguments');
    $arguments = $method->invoke($mock, ServiceTest::class);

    assert(is_array($arguments));
    $this->assertArrayHasKey('name', $arguments);
    $this->assertEquals('test', $arguments['name']);
  }

  /**
   * Test reading an unknown attribute.
   */
  public function testReadUnknownAttribute(): void {
    $mock = new #[\Attribute] class() {

      use AttributeReaderTrait;
    };

    // We need to use reflection because the method is protected.
    $class = new \ReflectionClass($mock);
    $method = $class->getMethod('readAttributeArguments');
    $arguments = $method->invoke($mock, ServiceTest::class);

    assert(is_array($arguments));
    $this->assertCount(0, $arguments);
  }

}
