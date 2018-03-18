<?php

namespace Drupal\outline;

use Drupal\Core\Config\Entity\ConfigEntityStorage;

/**
 * Defines a storage handler class for outlines.
 */
class OutlineStorage extends ConfigEntityStorage implements OutlineStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function resetCache(array $ids = NULL) {
    drupal_static_reset('outline_get_names');
    parent::resetCache($ids);
  }

  /**
   * {@inheritdoc}
   */ 
  public function getToplevelEids($oid, $root_entry_id) {
    $query = \Drupal::entityQuery('outline_entry');
    $query->condition('oid', $oid);
    $query->condition('parent', $root_entry_id);
    $entry_ids = $query->execute();
    return $entry_ids;
  }
}
