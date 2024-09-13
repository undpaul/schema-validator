<?php

namespace SchemaValidator\Tests\Kernel\Attribute;

use SchemaValidator\Attribute\AsCommand;
use SchemaValidator\Attribute\AttributeReaderTrait;
use SchemaValidator\Command\CommandBase;
use SchemaValidator\Tests\Kernel\KernelTestBase;

/**
 * Tests custom PHP attributes.
 */
class AttributeTest extends KernelTestBase {

  use AttributeReaderTrait;

  /**
   * Tests attribute constructions for \SchemaValidator\Attribute\AsCommand.
   */
  public function testAsCommandConstruction(): void {
    /** @var \SchemaValidator\Command\CommandBase $command_mock */
    $command_mock = new #[AsCommand(name: 'test:as-command', description: 'Test command')] class extends CommandBase {

    };
    $command_name = $command_mock::getDefaultName();
    $command_description = $command_mock::getDefaultDescription();

    $this->assertSame('test:as-command', $command_name);
    $this->assertSame('Test command', $command_description);
  }

}
