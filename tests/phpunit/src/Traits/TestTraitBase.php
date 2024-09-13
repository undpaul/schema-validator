<?php

namespace SchemaValidator\Tests\Traits;

/**
 * Base test trait.
 */
trait TestTraitBase {

  /**
   * Asserts an array contains another array.
   *
   * @param array<mixed> $haystack
   *   Array that should contain $needle.
   * @param array<mixed> $needle
   *   Array that should be in $haystack.
   */
  public function assertArrayContainsArray(array $haystack, array $needle): void {
    $this->assertCount(0, array_diff_key($needle, $haystack));
  }

}
