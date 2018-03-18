<?php

namespace Drupal\outline;

use Drupal\Core\Entity\ContentEntityStorageInterface;

/**
 * Defines an interface for outline entry entity storage classes.
 */
interface EntryStorageInterface extends ContentEntityStorageInterface {

  /**
   * Finds the children for an entry ID.
   *
   * @param int $eid
   *   Entry ID to retrieve parents for.
   * @param string $oid
   *   An optional outline ID to restrict the child search.
   *
   * @return \Drupal\outline\EntryInterface[]
   *   An array of entry objects that are the children of the entry $eid.
   */
  public function loadChildren($eid, $oid = NULL);

  /**
   * Finds all entries for a given outline ID.
   *
   * @param string $oid
   *   Outline ID to retrieve entries for.
   * @param int $parent
   *   The entry ID under which to generate the tree. If 0, generate the tree
   *   for the entire outline.
   * @param int $max_depth
   *   The number of levels of the tree to return. Leave NULL to return all
   *   levels.
   * @param bool $load_entities
   *   If TRUE, a full entity load will occur on the entry objects. Otherwise
   *   they are partial objects queried directly from the {outline_entry_data}
   *   table to save execution time and memory consumption when listing large
   *   numbers of entries. Defaults to FALSE.
   *
   * @return object[]|\Drupal\outline\EntryInterface[]
   *   An array of entry objects that are the children of the outline $oid.
   */
  public function loadTree($oid, $parent = 0, $max_depth = NULL, $load_entities = FALSE);

  /**
   * Reset the weights for a given outline ID.
   *
   * @param string $oid
   *   Outline ID to retrieve entries for.
   */
  public function resetWeights($oid);


}
