<?php

namespace SchemaValidator\Command;

use SchemaValidator\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Base command.
 */
abstract class CommandBase extends Command implements CommandInterface {

  /**
   * {@inheritdoc}
   *
   * @codeCoverageIgnore
   */
  #[\Override]
  public static function getDefaultName(): ?string {
    $attribute = (new \ReflectionClass(static::class))->getAttributes(AsCommand::class);
    if ($attribute) {
      return $attribute[0]->newInstance()->name;
    }

    return NULL;
  }

  /**
   * {@inheritdoc}
   *
   * @codeCoverageIgnore
   */
  #[\Override]
  public static function getDefaultDescription(): ?string {
    $attribute = (new \ReflectionClass(static::class))->getAttributes(AsCommand::class);
    if ($attribute) {
      return $attribute[0]->newInstance()->description;
    }

    return NULL;
  }

  /**
   * {@inheritdoc}
   */
  #[\Override]
  protected function configure(): void {
    parent::configure();

    // Get arguments defined in attribute.
    $arguments_defined = $this->getArgumentDefinitions();

    // Prepare arguments.
    foreach ($arguments_defined as $argument_name => $argument_definition) {
      if (is_string($argument_definition)) {
        // Expand argument definition.
        $arguments_defined[$argument_name] = [
          'description' => $argument_definition,
          'mode' => InputArgument::REQUIRED,
        ];
      }

      /** @var string $argument_description */
      $argument_description = $arguments_defined[$argument_name]['description'] ?? '';
      /** @var int|null $argument_mode */
      $argument_mode = $arguments_defined[$argument_name]['mode'] ?? InputArgument::REQUIRED;

      // Add as command argument.
      $this->addArgument(
        name: $argument_name,
        description: $argument_description,
        mode: $argument_mode,
        default: $arguments_defined[$argument_name]['default'] ?? NULL,
      );
    }

    // Get options defined in attribute.
    $options_defined = $this->getOptionDefinitions();

    foreach ($options_defined as $option_name => $option) {
      if (is_string($option)) {
        // Expand option definition.
        $options_defined[$option_name] = [
          'description' => $option,
          'mode' => InputOption::VALUE_REQUIRED,
        ];
      }

      /** @var string $option_description */
      $option_description = $options_defined[$option_name]['description'] ?? '';
      /** @var string|null $option_shortcut */
      $option_shortcut = $options_defined[$option_name]['shortcut'] ?? NULL;
      /** @var int|null $option_mode */
      $option_mode = $options_defined[$option_name]['mode'] ?? NULL;

      $this->addOption(
        name: $option_name,
        description: $option_description,
        shortcut: $option_shortcut,
        mode: $option_mode,
        default: $options_defined[$option_name]['default'] ?? NULL,
      );
    }
  }

  /**
   * {@inheritdoc}
   */
  #[\Override]
  protected function execute(InputInterface $input, OutputInterface $output): int {
    return Command::SUCCESS;
  }

  /**
   * {@inheritdoc}
   */
  #[\Override]
  public function getArgumentDefinitions(): array {
    $arguments = [];

    $attribute = (new \ReflectionClass(static::class))->getAttributes(AsCommand::class);
    if ($attribute) {
      $arguments = array_merge($arguments, $attribute[0]->newInstance()->arguments);
    }

    /** @var array<string, array<string, int|string>|string> $arguments */
    return $arguments;
  }

  /**
   * {@inheritdoc}
   */
  #[\Override]
  public function getOptionDefinitions(): array {
    $options = [];

    $attribute = (new \ReflectionClass(static::class))->getAttributes(AsCommand::class);
    if ($attribute) {
      $options = array_merge($options, $attribute[0]->newInstance()->options);
    }

    /** @var array<string, array<string, int|string>|string> $options */
    return $options;
  }

}
