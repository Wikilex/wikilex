<?php

/**
 * @file
 * Contains \Drupal\backup_db\BackupDatabaseClientInterface
 */

namespace Drupal\backup_db;

/**
 * Describes the BackupDatabaseClient class.
 */
interface BackupDatabaseClientInterface {

    /**
     * Peform the database export.
     */
    public function dump();
}
