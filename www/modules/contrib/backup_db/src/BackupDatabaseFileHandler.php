<?php

/**
 * @file
 * Contains \Drupal\backup_db\BackupDatabaseFileHandler
 */

namespace Drupal\backup_db;

use Drupal\Core\File\FileSystem;
use Drupal\backup_db\BackupDatabaseFile;

/**
 * BackupDatabaseFileHandler class.
 */
class BackupDatabaseFileHandler {

  /**
   * @var \Drupal\backup_db\BackupDatabaseFile
   */
  protected $file;

  /**
   * @var \Drupal\Core\File\FileSystem
   */
  protected $filesystem;

  /**
   * @var File config
   */
  protected $config;

  /**
   * @param \Drupal\backup_db\BackupDatabaseFile
   *    The database export file to act on.
   *
   * @param \Drupal\Core\File\FileSystem $filesystem
   *    Provides helpers to operate on files and stream wrappers.
   */
  public function __construct(BackupDatabaseFile $file, FileSystem $filesystem) {
    $this->file = $file;
    $this->filesystem = $filesystem;
  }

  /**
   * Handles file generation.
   *
   * @param $config
   */
  public function setupFile($config) {
    $this->setConfig($config);

    $path = $this->createFilePath();
    $extension = $this->createFileType();

    $this->file->setFileName($this->config['name'] . '_' . time() . $extension);
    $this->file->setFileUri(file_create_filename(
      $this->file->getFileName(), $path
    ));
  }

  /**
   * @inheritdoc
   */
  public function getFile() {
    return $this->file;
  }

  /**
   * @inheritdoc
   */
  public function setFile(BackupDatabaseFile $file) {
    $this->file = $file;
  }

  /**
   * @inheritdoc
   *
   * @todo,
   */
  public function exits($uri) {

  }

  /**
   * Set default file info.
   */
  private function setConfig($config) {
    $this->config = [
      'date' => \Drupal::service('date.formatter')->format(
        time(),
        $config->get('date')
      ),
      'compress' => $config->get('settings.compress'),
      'name' => $config->get('filename'),
      'path' => $config->get('path')
    ];
  }

  /**
   * Create export location.
   */
  private function createFilePath() {
    $result = $this->config['path'];

    if (!file_prepare_directory($result, FILE_CREATE_DIRECTORY)) {
      $result = FALSE;

      \Drupal::logger('backup_db')->error('The requested directory @dir could not be created.',
        array(
          '@dir' => $this->config['path']
        )
      );
    }
    else if (!file_prepare_directory($result)) {
      $result = FALSE;

      \Drupal::logger('backup_db')->error('The requested directory @dir permissions are not writable.',
        array(
          '@dir' => $this->config['path']
        )
      );
    }

    if ($this->config['date']) {
      $filepath = $this->config['path'] . '/' . $this->config['date'];

      if (file_prepare_directory($filepath, FILE_CREATE_DIRECTORY)) {
        $result = $filepath;
      }
    }

    return $result;
  }

  /**
   * Determine the export type/ extension.
   */
  private function createFileType() {
    $type = 'application/octet-stream';
    $extension = '.sql';

    switch ($this->config['compress']) {
      case 'Gzip':
        $extension .= '.gz';
        $type = 'application/gzip';
        break;
      case 'Bzip2':
        $extension .= '.bz2';
        $type = 'application/x-bzip2';
    }

    $this->file->setFileType($type);
    return $extension;
  }

}
