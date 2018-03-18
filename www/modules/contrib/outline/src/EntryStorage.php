<?php

namespace Drupal\outline;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;

/**
 * Defines a storage class for outline entries.
 */
class EntryStorage extends SqlContentEntityStorage implements EntryStorageInterface {

  /**
   * The parent entry ID.
   *
   * @var int
   */
  protected $parent = 0;

  /**
   * Array of all loaded entry ancestry keyed by ancestor entry ID.
   *
   * @var array
   */
  protected $parentsAll = array();

  /**
   * Array of child entries keyed by parent entry ID.
   *
   * @var array
   */
  protected $children = array();

  /**
   * Array of entry parents keyed by outline ID and child entry ID.
   *
   * @var array
   */
  protected $treeParents = array();

  /**
   * Array of entry ancestors keyed by outline ID and parent entry ID.
   *
   * @var array
   */
  protected $treeChildren = array();

  /**
   * Array of entries in a tree keyed by outline ID and entry ID.
   *
   * @var array
   */
  protected $treeEntrys = array();

  /**
   * Array of loaded trees keyed by a cache id matching tree arguments.
   *
   * @var array
   */
  protected $trees = array();

  /**
   * {@inheritdoc}
   */
  public function resetCache(array $ids = NULL) {
    // @todo This is old taxonomy caching code.
    drupal_static_reset('outline_entry_count_nodes');
    $this->parents = array();
    $this->parentsAll = array();
    $this->children = array();
    $this->treeChildren = array();
    $this->treeParents = array();
    $this->treeEntrys = array();
    $this->trees = array();
    parent::resetCache($ids);
  }

  /**
   * {@inheritdoc}
   */
  public function loadChildren($eid, $oid = NULL) {
    if (!isset($this->children[$eid])) {
      $children = array();
      $query = $this->database->select('outline_entry_field_data', 't');
      $query->addField('t', 'eid');
      $query->condition('t.parent', $eid);
      if ($oid) {
        $query->condition('t.oid', $oid);
      }
      $query->condition('t.default_langcode', 1);
      $query->addTag('outline_entry_access');
      $query->orderBy('t.weight');
      $query->orderBy('t.name');
      if ($ids = $query->execute()->fetchCol()) {
        $children = $this->loadMultiple($ids);
      }
      $this->children[$eid] = $children;
    }
    return $this->children[$eid];
  }

  /**
   * {@inheritdoc}
   */
  public function loadTree($oid, $parent = 0, $max_depth = NULL, $load_entities = FALSE) {
    $cache_key = implode(':', func_get_args());
    if (!isset($this->trees[$cache_key])) {
      // We cache trees, so it's not CPU-intensive to call on an entry and its
      // children, too.
      if (!isset($this->treeChildren[$oid])) {
        $this->treeChildren[$oid] = array();
        $this->treeParents[$oid] = array();
        $this->treeEntrys[$oid] = array();
        $query = $this->database->select('outline_entry_field_data', 't');
        $result = $query
          ->addTag('outline_entry_access')
          ->fields('t')
          ->condition('t.oid', $oid)
          ->condition('t.default_langcode', 1)
          ->orderBy('t.weight')
          ->orderBy('t.name')
          ->execute();
        foreach ($result as $entry) {
          $this->treeChildren[$oid][$entry->parent][] = $entry->eid;
          $this->treeParents[$oid][$entry->eid][] = $entry->parent;
          $this->treeEntrys[$oid][$entry->eid] = $entry;
        }
      }

      // Load full entities, if necessary. The entity controller statically
      // caches the results.
      $entry_entities = array();
      if ($load_entities) {
        $entry_entities = $this->loadMultiple(array_keys($this->treeEntrys[$oid]));
      }

      $max_depth = (!isset($max_depth)) ? count($this->treeChildren[$oid]) : $max_depth;
      $tree = array();

      // Keeps track of the parents we have to process, the last entry is used
      // for the next processing step.
      $process_parents = array();
      $process_parents[] = $parent;

      // Loops over the parent entries and adds its children to the tree array.
      // Uses a loop instead of a recursion, because it's more efficient.
      while (count($process_parents)) {
        $parent = array_pop($process_parents);
        // The number of parents determines the current depth.
        $depth = count($process_parents);
        if ($max_depth > $depth && !empty($this->treeChildren[$oid][$parent])) {
          $has_children = FALSE;
          $child = current($this->treeChildren[$oid][$parent]);
          do {
            if (empty($child)) {
              break;
            }
            $entry = $load_entities ? $entry_entities[$child] : $this->treeEntrys[$oid][$child];
            if (isset($this->treeParents[$oid][$load_entities ? $entry->id() : $entry->eid])) {
              // Clone the entry so that the depth attribute remains correct
              // in the event of multiple parents.
              $entry = clone $entry;
            }
            $entry->depth = $depth;
            unset($entry->parent);
            $eid = $load_entities ? $entry->id() : $entry->eid;
            $entry->parents = $this->treeParents[$oid][$eid];
            $tree[] = $entry;
            if (!empty($this->treeChildren[$oid][$eid])) {
              $has_children = TRUE;

              // We have to continue with this parent later.
              $process_parents[] = $parent;
              // Use the current entry as parent for the next iteration.
              $process_parents[] = $eid;

              // Reset pointers for child lists because we step in there more
              // often with multi parents.
              reset($this->treeChildren[$oid][$eid]);
              // Move pointer so that we get the correct entry the next time.
              next($this->treeChildren[$oid][$parent]);
              break;
            }
          } while ($child = next($this->treeChildren[$oid][$parent]));

          if (!$has_children) {
            // We processed all entries in this hierarchy-level, reset pointer
            // so that this function works the next time it gets called.
            reset($this->treeChildren[$oid][$parent]);
          }
        }
      }
      $this->trees[$cache_key] = $tree;
    }
    return $this->trees[$cache_key];
  }

  /**
   * {@inheritdoc}
   */
  public function resetWeights($oid) {
    $this->database->update('outline_entry_field_data')
      ->fields(array('weight' => 0))
      ->condition('oid', $oid)
      ->execute();
  }

  /**
   * {@inheritdoc}
   */
  public function __sleep() {
    $vars = parent::__sleep();
    // Do not serialize static cache.
    unset($vars['parents'], $vars['parentsAll'], $vars['children'], $vars['treeChildren'], $vars['treeParents'], $vars['treeEntrys'], $vars['trees']);
    return $vars;
  }

  /**
   * {@inheritdoc}
   */
  public function __wakeup() {
    parent::__wakeup();
    // Initialize static caches.
    $this->parents = array();
    $this->parentsAll = array();
    $this->children = array();
    $this->treeChildren = array();
    $this->treeParents = array();
    $this->treeEntrys = array();
    $this->trees = array();
  }

}
