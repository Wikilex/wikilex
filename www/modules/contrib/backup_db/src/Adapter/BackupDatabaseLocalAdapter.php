<?php

/**
 * @file
 * Contains \Drupal\backup_db\Adapter\BackupDatabaseLocalAdapter
 */

namespace Drupal\backup_db\Adapter;

use Drupal\backup_db\Adapter\BackupDatabaseAdapterInterface;
use Drupal\backup_db\BackupDatabaseClientInterface;

/**
 * BackupDatabaseLocalAdapter class.
 */
class BackupDatabaseLocalAdapter implements BackupDatabaseAdapterInterface {

  /**
   * @var \Drupal\backup_db\BackupDatabaseClientInterface
   */
  private $client;

  /**
   * @param $client \Drupal\backup_db\BackupDatabaseClientInterface
   */
  public function __construct(BackupDatabaseClientInterface $client) {
    $this->client = $client;
  }

  /**
   * @inherit
   */
  public function export() {
    $handler = $this->client->getFileHandler();
    $handler->setupFile($this->client->getSettings());

    $file = $handler->getFile();
    $user = \Drupal::currentUser();

    // Create a file entity.
    $entity = entity_create('file', array(
      'uri' => $file->getFileUri(),
      'uid' => $user->id(),
      'status' => FILE_STATUS_PERMANENT,
    ));
    $entity->save();

    // Insert history entry.
    if ($entity->id()) {
      backup_db_history_insert(array(
        'fid' => $entity->id(),
        'name' => $file->getFileName(),
        'uri' => $file->getFileUri()
      ));

      $export = $this->client->dump();
      $export->start($file->getFileUri());
    }
    else {
      \Drupal::logger('backup_db')->error('File entity could not be created.');
    }

    return $entity->id();
  }

}
