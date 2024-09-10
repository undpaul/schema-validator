<?php

namespace SchemaValidator;

use Symfony\Component\Console\Application as ApplicationBase;

/**
 * Defines the main application.
 */
class Application extends ApplicationBase {

  /**
   * Creates a new application object.
   */
  public function __construct() {
    // @codeCoverageIgnoreStart
    parent::__construct('Schema Validator', '1.0.0');
    // @codeCoverageIgnoreEnd
  }

}
