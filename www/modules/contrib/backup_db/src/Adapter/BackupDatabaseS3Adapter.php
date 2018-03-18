<?php

/**
 * @file
 * Contains \Drupal\backup_db\Adapter\BackupDatabaseS3Adapter
 */

namespace Drupal\backup_db\Adapter;

use Drupal\backup_db\Adapter\BackupDatabaseAdapterInterface;
use Drupal\backup_db\BackupDatabaseClientInterface;

/**
 * AWS S3 adapter class.
 */
class BackupDatabaseS3Adapter implements BackupDatabaseAdapterInterface {

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
   * @todo, stream export.
   */
  public function export() {
    
  }
}
