<?php

namespace SchemaValidator\Tests\Kernel;

use SchemaValidator\Tests\Traits\TestTraitBase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Base kernel test class.
 */
abstract class KernelTestBase extends KernelTestCase {

  use TestTraitBase;

}
