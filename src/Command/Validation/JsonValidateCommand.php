<?php

namespace SchemaValidator\Command\Validation;

use SchemaValidator\Attribute\AsCommand;
use SchemaValidator\Command\CommandBase;
use SchemaValidator\Validation\ValidatorInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Defines a command to validate a JSON file agains a given schema.
 */
#[AsCommand(
  name: 'json:validate',
  description: "Validate a JSON file.\n  If no path to a schema file is given, the validator tries to identify the schema file from the JSON file itself. To set the path to the schema file in the JSON file use the \$schema key.",
  arguments: [
    'file' => 'Path to JSON file.',
    'schema' => [
      'description' => 'Path to JSON schema.',
      'mode' => InputArgument::OPTIONAL,
    ],
  ]
)]
class JsonValidateCommand extends CommandBase {

  /**
   * Constructs a new ValidateCommand.
   *
   * @param \SchemaValidator\Validation\ValidatorInterface $validator
   *   The schema validator.
   */
  public function __construct(
    protected ValidatorInterface $validator,
  ) {
    parent::__construct();
  }

  /**
   * {@inheritdoc}
   */
  #[\Override]
  protected function execute(InputInterface $input, OutputInterface $output): int {
    parent::execute($input, $output);

    /** @var string $json_file */
    $json_file = $input->getArgument('file');
    /** @var string|null $schema */
    $schema = $input->hasArgument('schema') ? $input->getArgument('schema') : NULL;

    if (!is_readable($json_file)) {
      return Command::FAILURE;
    }

    /** @var string $json_contents */
    $json_contents = file_get_contents($json_file);
    /** @var object $json */
    $json = json_decode($json_contents);

    $this->validator->isValid($json, $schema);

    if (!$output->isQuiet() && ($input->getOption('quiet') !== TRUE)) {
      $output->writeln('valid');
    }

    return Command::SUCCESS;
  }

}
