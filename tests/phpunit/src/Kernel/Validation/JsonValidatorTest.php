<?php

namespace SchemaValidator\Tests\Kernel\Validation;

use SchemaValidator\Attribute\ServiceTest;
use SchemaValidator\Tests\Kernel\ServiceTestBase;

/**
 * Tests the JSON Validator service.
 */
#[ServiceTest(
    name: 'schema_validator.validator',
  )]
class JsonValidatorTest extends ServiceTestBase {

  /**
   * Test basic schema validation.
   *
   * @dataProvider schemaValidationProvider
   */
  public function testSchemaValidation(string $filename, ?string $schema, bool $result): void {
    /** @var \SchemaValidator\Validation\ValidatorInterface $service */
    $service = $this->service;

    /** @var string $json_contents */
    $json_contents = file_get_contents($filename);
    /** @var object $json */
    $json = json_decode($json_contents);

    $validation_result = $service->isValid($json, $schema);
    $this->assertEquals($result, $validation_result);
  }

  /**
   * Data provider for schema validation tests.
   *
   * @return array<array<mixed>>
   *   List of data to test and the expected results.
   */
  public function schemaValidationProvider(): array {
    return [
      [
        'vfs://root/data/projects_without_schema.json',
        NULL,
        TRUE,
      ],
      [
        'vfs://root/data/projects_with_schema.json',
        NULL,
        TRUE,
      ],
    ];
  }

  /**
   * Test validating with exception.
   */
  public function testSchemaValidationFails(): void {
    /** @var \SchemaValidator\Validation\ValidatorInterface $service */
    $service = $this->service;

    $filename = 'vfs://root/data/projects_without_schema.json';
    $schema = 'vfs://root/schema/drupal/projects.json';

    /** @var string $json_contents */
    $json_contents = file_get_contents($filename);
    /** @var object $json */
    $json = json_decode($json_contents);

    $this->expectException('SchemaValidator\Exception\SchemaValidationException');
    $this->expectExceptionMessageMatches('/\$schema: The property \$schema is required/');
    $this->expectExceptionMessageMatches('/project_1\.\$schema: The property \$schema is required/');
    $service->isValid($json, $schema);
  }

}
