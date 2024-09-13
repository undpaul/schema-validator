<?php

namespace SchemaValidator\Tests\Kernel\Command;

use SchemaValidator\Attribute\AttributeReaderTrait;
use SchemaValidator\Attribute\CommandTest;
use SchemaValidator\Tests\Kernel\KernelTestBase;
use SchemaValidator\Tests\Traits\FileSystemTrait;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Base class for command tests.
 */
abstract class CommandTestBase extends KernelTestBase {

  use AttributeReaderTrait;
  use FileSystemTrait;

  /**
   * The application.
   *
   * @var \Symfony\Bundle\FrameworkBundle\Console\Application
   */
  protected Application $application;

  /**
   * The command to test.
   *
   * @var \Symfony\Component\Console\Command\Command
   */
  protected Command $command;

  /**
   * Name of command as entered in the shell.
   *
   * @var string
   */
  private string $commandName;

  /**
   * List of command arguments.
   *
   * @var array<string, string>
   */
  public array $arguments = [];

  /**
   * {@inheritdoc}
   */
  #[\Override]
  protected function setUp(): void {
    self::bootKernel();

    assert(!is_null(self::$kernel));
    $this->application = new Application(self::$kernel);

    // Get all arguments from attribute "#[CommandTest]".
    $arguments = $this->readAttributeArguments(CommandTest::class);
    assert(!is_null($arguments['name']));

    assert(is_string($arguments['name']));
    $this->commandName = $arguments['name'];
    $this->command = $this->application->find($this->commandName);

    if (array_key_exists('arguments', $arguments)) {
      assert(is_array($arguments['arguments']));
      $this->arguments = $arguments['arguments'];
    }

    // Initialize the virtual file system.
    $this->initFileSystem();
  }

  /**
   * Execute the command.
   *
   * @param array<string, string|null> $additional_arguments
   *   List of additional arguments.
   * @param bool $force_success
   *   Do not allow the command to fail. Defaults to <code>TRUE</code>.
   *
   * @return \Symfony\Component\Console\Tester\CommandTester
   *   The command tester.
   */
  protected function executeCommand(array $additional_arguments = [], bool $force_success = TRUE): CommandTester {
    $command_tester = new CommandTester($this->command);

    $arguments = array_merge($this->arguments, $additional_arguments);

    // Run the command using the defined arguments and options.
    $command_tester->execute($arguments);

    if ($force_success) {
      $command_tester->assertCommandIsSuccessful();
    }

    return $command_tester;
  }

  /**
   * Replace an existing service with a mocked object.
   *
   * @param string $name
   *   Name of service to replace.
   * @param object $mock
   *   The mocked object.
   */
  protected function replaceService(string $name, object $mock): void {
    self::$kernel?->getContainer()->set($name, $mock);
  }

}
