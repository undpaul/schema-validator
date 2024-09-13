<?php

namespace SchemaValidator\Tests\Kernel\Exception;

use SchemaValidator\Exception\SchemaValidationException;
use SchemaValidator\Tests\Kernel\KernelTestBase;

/**
 * Tests ContextAwareException.
 */
class ContextAwareExceptionTest extends KernelTestBase {

  /**
   * Tests getting a context from the exception.
   */
  public function testGetContext(): void {
    $schema = 'vfs://root/schema/drupal/projects.json';
    $errors_defined = [
      [
        'test' => 'Test message',
      ],
    ];

    /** @var \SchemaValidator\Exception\ContextAwareExceptionInterface $exception */
    $exception = new SchemaValidationException($schema, $errors_defined);

    $context = $exception->getContext();
    $this->assertArrayHasKey('errors', $context);

    /** @var array<string, string> $errors */
    $errors = $context['errors'];

    // Does this specific error exist in the list?
    $error_exists = array_filter($errors, function ($error) use ($errors_defined) {
      return $error == $errors_defined[0];
    });
    $this->assertCount(1, $error_exists);
  }

  /**
   * Tests setting a context to the exception.
   */
  public function testSetContext(): void {
    $schema = 'vfs://root/schema/drupal/projects.json';
    $errors_defined = [
      [
        'test' => 'Test message',
      ],
    ];

    /** @var \SchemaValidator\Exception\ContextAwareExceptionInterface $exception */
    $exception = new SchemaValidationException($schema, $errors_defined);

    $context = [
      'test' => 'value',
    ];

    $exception->setContext($context);

    $exception_context = $exception->getContext();
    $this->assertArrayNotHasKey('errors', $exception_context);
    $this->assertArrayHasKey('test', $exception_context);
  }

  /**
   * Tests adding a context to the exception.
   */
  public function testAddContext(): void {
    $schema = 'vfs://root/schema/drupal/projects.json';
    $errors_defined = [
      [
        'test' => 'Test message',
      ],
    ];

    /** @var \SchemaValidator\Exception\ContextAwareExceptionInterface $exception */
    $exception = new SchemaValidationException($schema, $errors_defined);

    $exception->addContext('test', 'value');

    $exception_context = $exception->getContext();
    $this->assertArrayHasKey('errors', $exception_context);
    $this->assertArrayHasKey('test', $exception_context);
  }

}
