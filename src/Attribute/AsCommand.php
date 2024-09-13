<?php

namespace SchemaValidator\Attribute;

use Symfony\Component\Console\Attribute\AsCommand as SymfonyCommand;

/**
 * Service tag to autoconfigure commands.
 *
 * @codeCoverageIgnore
 */
#[\Attribute(\Attribute::TARGET_CLASS)]
class AsCommand extends SymfonyCommand {

  /**
   * Defines a new command.
   *
   * @param string $name
   *   The name of the command, used when calling it (i.e. "cache:clear").
   * @param string|null $description
   *   The description of the command, displayed with the help page.
   * @param array<string, string|array<mixed>> $arguments
   *   List of arguments for the command.
   * @param array<string, string|array<mixed>> $options
   *   List of options for the command.
   * @param string[] $aliases
   *   The list of aliases of the command. The command will be executed when
   *   using one of them (i.e. "cache:clean").
   * @param bool $hidden
   *   If true, the command won't be shown when listing all the available
   *   commands, but it can still be run as any other command.
   */
  public function __construct(
    public string $name,
    public ?string $description = NULL,
    public array $arguments = [],
    public array $options = [],
    public array $aliases = [],
    public bool $hidden = FALSE,
  ) {
    if (!$hidden && !$aliases) {
      return;
    }

    $name = explode('|', $name);
    $name = array_merge($name, $aliases);

    if ($hidden && '' !== $name[0]) {
      // @codeCoverageIgnoreStart
      array_unshift($name, '');
      // @codeCoverageIgnoreEnd
    }

    $this->name = implode('|', $name);
  }

}
