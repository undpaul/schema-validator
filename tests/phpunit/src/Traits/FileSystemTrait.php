<?php

namespace SchemaValidator\Tests\Traits;

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;

/**
 * Trait for file system functions.
 */
trait FileSystemTrait {

  /**
   * The virtual file system.
   *
   * @var \org\bovigo\vfs\vfsStreamDirectory
   */
  protected vfsStreamDirectory $fileSystem;

  /**
   * Get the virtual file system instance.
   *
   * @return \org\bovigo\vfs\vfsStreamDirectory
   *   The virtual file system.
   */
  public function getFileSystem(): vfsStreamDirectory {
    return $this->fileSystem;
  }

  /**
   * Initialize the virtual file system.
   *
   * @return \org\bovigo\vfs\vfsStreamDirectory
   *   The virtual file system.
   */
  public function initFileSystem(): vfsStreamDirectory {
    $file_structure = [
      'data' => [
        'projects_without_schema.json' => '{
  "project_1": {
    "docroot": "\/dev\/projects\/project_1\/docroot",
    "config": "\/dev\/projects\/project_1\/environments\/_default\/config\/sync"
  },
  "project_2": {
    "docroot": "\/dev\/projects\/project_2\/docroot",
    "config": "\/dev\/projects\/project_2\/environments\/_default\/config\/sync"
  }
}',
        'projects_with_schema.json' => '{
  "$schema": "vfs://root/schema/drupal/projects.json",
  "project_2_ddev": {
    "$schema": "vfs://root/schema/drupal/project.json",
    "docroot": "\/home\/docroot",
    "config": "\/home\/environments\/_default\/config\/sync"
  },
  "project_1": {
    "$schema": "vfs://root/schema/drupal/project.json",
    "docroot": "\/dev\/projects\/project_1\/docroot",
    "config": "\/dev\/projects\/project_1\/environments\/_default\/config\/sync"
  }
}
',
      ],
      'schema' => [
        'drupal' => [
          'projects.json' => '{
  "$schema": "https://json-schema.org/draft/2020-12/schema",
  "$id": "schema/drupal/projects.json",
  "title": "Project list",
  "description": "List of available projects.",
  "type": "object",
  "properties": {
    "$schema": {
      "description": "The JSON schema reference URI.",
      "type": "string",
      "format": "uri"
    }
  },
  "additionalProperties": {
    "$ref": "/schema/drupal/project.json"
  },
  "required": [
    "$schema"
  ],
  "minProperties": 1
}',
          'project.json' => '{
  "$schema": "https://json-schema.org/draft/2020-12/schema",
  "$id": "schema/drupal/project.json",
  "title": "Project",
  "description": "A Drupal project",
  "type": "object",
  "properties": {
    "$schema": {
      "description": "The JSON schema reference URI.",
      "type": "string",
      "format": "uri"
    },
    "docroot": {
      "description": "Path to project docroot.",
      "type": "string",
      "format": "uri-reference"
    },
    "config": {
      "description": "Path to project config directory.",
      "type": "string",
      "format": "uri-reference"
    },
    "export": {
      "description": "Project-specific path to export directory.",
      "type": "string",
      "format": "uri-reference"
    }
  },
  "required": [
    "$schema",
    "docroot",
    "config"
  ],
  "additionalProperties": false
}',
        ],
      ],
    ];
    // Initialize virtual filesystem.
    $this->fileSystem = vfsStream::setup(
        structure: $file_structure,
        permissions: 444,
    );

    return $this->fileSystem;
  }

}
