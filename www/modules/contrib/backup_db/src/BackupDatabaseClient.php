<?php

/**
 * @file
 * Contains \Drupal\backup_db\BackupDatabaseClient
 *
 * Usage
 *  $client = \Drupal::service('backup_db.client');
 *  // Do client things (update settings, set new connection)
 *  $client->setConnection();
 *  // Select our adapter (AWS)
 *  $handler = new BackupDatabaseS3Adapter($client);
 *  // Do the magic
 *  $handler->export();
 *
 * @todo,
 * error handler
 */

namespace Drupal\backup_db;

use Ifsnop\Mysqldump as IMysqldump;
use Drupal\Core\Database\Connection;
use Drupal\Core\Config\ConfigFactoryInterface;

use Drupal\backup_db\BackupDatabaseFileHandler;
use Drupal\backup_db\BackupDatabaseClientInterface;

/**
 * BackupDatabaseClient class.
 */
class BackupDatabaseClient implements BackupDatabaseClientInterface {
  
  /**
   * @var \Drupal\backup_db\BackupDatabaseFileHandler
   */
  protected $handler;

  /**
   * @var \Drupal\Core\Database\Connection
   */
  protected $connection;

  /**
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $config;

  /**
   * @param $backup_file \Drupal\backup_db\BackupDatabaseFileHandler
   * @param $connection \Drupal\Core\Database\Connection
   * @param $config \Drupal\Core\Config\ConfigFactoryInterface
   */
  public function __construct(BackupDatabaseFileHandler $handler, Connection $connection, ConfigFactoryInterface $config) {
    $this->handler = $handler;
    $this->connection = $connection;
    $this->config = $config;
  }

  /**
   * Perform the database dump.
   *
   * @return
   *  Mysqldump
   */
  public function dump() {
    // Get configuration for export.
    $config = $this->getSettings();
    $options = $this->getConnectionOptions();

    // Return export to the adapter.
    return new IMysqldump\Mysqldump(
      $options['connection'],
      $options['username'],
      $options['password'],
      [
        'include-tables' => $config->get('settings.include_tables'),
        'exclude-tables' => $config->get('settings.exclude_tables'),
        'compress' => $config->get('settings.compress'),
        'no-data' => $config->get('settings.no_data'),
        'add-drop-table' => $config->get('settings.add_drop_table'),
        'single-transaction' => $config->get('settings.single_transaction'),
        'lock-tables' => $config->get('settings.lock_tables'),
        'add-locks' => $config->get('settings.add_locks'),
        'extended-insert' => $config->get('settings.extended_insert'),
        'complete-insert' => $config->get('settings.complete_insert'),
        'disable-keys' => $config->get('settings.disable_keys'),
        'where' => $config->get('settings.where'),
        'no-create-info' => $config->get('settings.no_create_info'),
        'skip-triggers' => $config->get('settings.skip_triggers'),
        'add-drop-trigger' => $config->get('settings.add_drop_trigger'),
        'routines' => $config->get('settings.routines'),
        'hex-blob' => $config->get('settings.hex_blob'),
        'databases' => $config->get('settings.databases'),
        'add-drop-database' => $config->get('settings.add_drop_database'),
        'skip-tz-utc' => $config->get('settings.skip_tz_utc'),
        'no-autocommit' => $config->get('settings.no_autocommit'),
        'default-character-set' => $config->get('settings.default_character_set'),
        'skip-comments' => $config->get('settings.skip_comments'),
        'skip-dump-date' => $config->get('settings.skip_dump_date')
      ]
    );
  }

  /**
   * Return formatted connection options.
   */
  public function getConnectionOptions() {
    $options = $this->connection->getConnectionOptions();

    // Requires formatting as a string.
    $connection = $options['driver'] . ':' . 'host=';
    $connection .= $options['host'] . ';port=';
    $connection .= $options['port'] . ';dbname=';
    $connection .= $options['database'];

    return [
      'connection' => $connection,
      'username' => $options['username'],
      'password' => $options['password']
    ];
  }
  
  /**
   * Return the connection.
   */
  public function getConnection() {
    return $this->connection;
  }

  /**
   * Set or update the current database connection.
   *
   * @param $connection \Drupal\Core\Database\Connection
   */
  public function setConnection(Connection $connection) {
    $this->connection = $connection;
  }

  /**
   * Return the file handler.
   */
  public function getFileHandler() {
    return $this->handler;
  }

  /**
   * Return the BackupDatabase settings.
   */
  public function getSettings($name = 'backup_db.settings') {
    return $this->config->get($name);
  }

}
