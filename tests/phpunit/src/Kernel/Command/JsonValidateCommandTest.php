<?php

namespace SchemaValidator\Tests\Kernel\Command;

use SchemaValidator\Attribute\CommandTest;
use Symfony\Component\Console\Command\Command;

/**
 * Tests json:validate command handling.
 */
#[CommandTest(
  name: 'json:validate',
)]
class JsonValidateCommandTest extends CommandTestBase {

  /**
   * Tests the command without any arguments.
   */
  public function testExecuteCommandNoArguments(): void {
    $this->expectException('\Symfony\Component\Console\Exception\RuntimeException');
    $this->expectExceptionMessage('Not enough arguments (missing: "file").');

    $this->executeCommand();
  }

  /**
   * Tests the command with a JSON file having an inline schema.
   */
  public function testExecuteCommandFileInlineSchema(): void {
    $file_name = 'vfs://root/data/projects_with_schema.json';

    $command_arguments = [
      'file' => $file_name,
    ];
    $command_tester = $this->executeCommand($command_arguments);
    $output = $command_tester->getDisplay();

    $this->assertStringStartsWith('valid', $output);
  }

  /**
   * Tests the command with a JSON file using an external schema.
   */
  public function testExecuteCommandFileExternalSchema(): void {
    $file_name = 'vfs://root/data/projects_without_schema.json';
    $schema = 'vfs://root/schema/drupal/projects.json';

    $command_arguments = [
      'file' => $file_name,
      'schema' => $schema,
    ];

    $this->expectException('\SchemaValidator\Exception\SchemaValidationException');
    $this->executeCommand($command_arguments);
    $this->expectExceptionMessageMatches('/project_1\.\$schema: The property \$schema is required/');
  }

  /**
   * Tests the command with a JSON file using no schema.
   */
  public function testExecuteCommandFileNoSchema(): void {
    $file_name = 'vfs://root/data/projects_without_schema.json';

    $command_arguments = [
      'file' => $file_name,
    ];
    $command_tester = $this->executeCommand($command_arguments);
    $output = $command_tester->getDisplay();

    $this->assertStringStartsWith('valid', $output);
  }

  /**
   * Tests the command with an unreadable JSON file.
   */
  public function testExecuteCommandUnreadableFile(): void {
    $file_name = 'vfs://root/data/does-not-exist.json';

    $command_arguments = [
      'file' => $file_name,
    ];
    $command_tester = $this->executeCommand($command_arguments, FALSE);
    // Command should fail.
    $this->assertSame($command_tester->getStatusCode(), Command::FAILURE);
  }

}
