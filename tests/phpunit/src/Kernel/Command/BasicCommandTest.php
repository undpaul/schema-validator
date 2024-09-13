<?php

namespace SchemaValidator\Tests\Kernel\Command;

use SchemaValidator\Attribute\AsCommand;
use SchemaValidator\Attribute\CommandTest;
use SchemaValidator\Command\CommandBase;

/**
 * Tests basic command command handling.
 */
#[CommandTest(
  // Use this command even we do not actually use it.
  name: 'json:validate',
)]
class BasicCommandTest extends CommandTestBase {

  /**
   * Tests the command without any arguments.
   */
  public function testExecuteCommandInitialization(): void {
    /** @var \SchemaValidator\Command\CommandInterface $command_mock */
    $command_mock = new #[AsCommand(
        name: 'test:command', arguments: [
          'arg1' => 'First argument',
        ], options: [
          'option1' => 'First option',
        ],
      )] class extends CommandBase {
      };

    $arguments = $command_mock->getArgumentDefinitions();
    $options = $command_mock->getOptionDefinitions();

    $this->assertArrayHasKey('arg1', $arguments);
    $this->assertArrayHasKey('option1', $options);
  }

}
