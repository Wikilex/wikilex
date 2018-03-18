<?php

namespace Drupal\outline;

use Drupal\Core\Config\Entity\ConfigEntityStorageInterface;

/**
 * Defines an interface for outline entity storage classes.
 */
interface OutlineStorageInterface extends ConfigEntityStorageInterface {

  /**
   * Get top-level entry IDs of outline.
   *
   * @param string $oid
   *   Outline ID.
   *
   * @param string $root_entry_id
   *   Root Entry ID.
   *
   * @return array
   *   Array of top-level entry IDs.
   */
  public function getToplevelEids($oid, $root_entry_id);

}
