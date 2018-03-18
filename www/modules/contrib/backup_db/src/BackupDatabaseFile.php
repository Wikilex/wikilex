<?php

/**
 * @file
 * Contains \Drupal\backup_db\BackupDatabaseFile
 */

namespace Drupal\backup_db;

/**
 * BackupDatabaseFile class.
 */
class BackupDatabaseFile {

  /**
   * @var File name
   */
  protected $name;

  /**
   * @var File type
   */
  protected $type;

  /**
   * @var File uri
   */
  protected $uri;

  /**
   * Return the file name.
   */
  public function getFileName() {
    return $this->name;
  }

  /**
   * Set the file uri.
   */
  public function setFileName($name) {
    $this->name = $name;
  }

  /**
   * Return the file type.
   */
  public function getFileType() {
    return $this->type;
  }

  /**
   * Set the file type.
   */
  public function setFileType($type) {
    $this->type = $type;
  }

  /**
   * Return the file uri.
   */
  public function getFileUri() {
    return $this->uri;
  }

  /**
   * Set the file uri.
   */
  public function setFileUri($uri) {
    $this->uri = $uri;
  }

}
