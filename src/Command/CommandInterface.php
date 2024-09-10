<?php

namespace SchemaValidator\Command;

/**
 * Interface for console commands.
 */
interface CommandInterface {

  /**
   * Get list of argument definitions for this command.
   *
   * @return array<string, string|array<string, string|int>>
   *   List of argument definitions.
   */
  public function getArgumentDefinitions(): array;

  /**
   * Get list of option definitions for this command.
   *
   * @return array<string, string|array<string, string|int>>
   *   List of option definitions.
   */
  public function getOptionDefinitions(): array;

}
