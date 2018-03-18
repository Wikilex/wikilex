<?php

/**
 * @file
 * Contains \Drupal\backup_db\Adapter\BackupDatabaseAdapterInterface
 */

namespace Drupal\backup_db\Adapter;

/**
 * BackupDatabase Adapter Interface.
 */
interface BackupDatabaseAdapterInterface {

  /**
   * Perform the export.
   */
  public function export();

}
