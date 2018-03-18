<?php

namespace Drupal\outline\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\outline\OutlineInterface;

/**
 * Defines the outline entity.
 *
 * @ConfigEntityType(
 *   id = "outline",
 *   label = @Translation("Outline"),
 *   handlers = {
 *     "storage" = "Drupal\outline\OutlineStorage",
 *     "list_builder" = "Drupal\outline\OutlineListBuilder",
 *     "form" = {
 *       "default" = "Drupal\outline\OutlineForm",
 *       "delete" = "Drupal\outline\Form\OutlineDeleteForm"
 *     }
 *   },
 *   admin_permission = "administer outlines",
 *   config_prefix = "outline",
 *   bundle_of = "outline_entry",
 *   entity_keys = {
 *     "id" = "oid",
 *     "label" = "name",
 *     "weight" = "weight"
 *   },
 *   links = {
 *     "canonical" = "/outline/{outline}",
 *     "collection" = "/admin/content/outline",
 *     "add-form" = "/outline/add",
 *     "edit-form" = "/outline/{outline}/edit",
 *     "delete-form" = "/outline/{outline}/delete",
 *   },
 *   config_export = {
 *     "name",
 *     "description",
 *     "weight",
 *     "render",
 *     "expand_levels",
 *     "hide_name",
 *     "hide_site",
 *     "oid",
 *     "root_entry_id",
 *     "site_entry_id",
 *   }
 * )
 */
class Outline extends ConfigEntityBundleBase implements OutlineInterface {

  /**
   * Name of the outline.
   *
   * @var string
   */
  protected $name;

  /**
   * Description of the outline.
   *
   * @var string
   */
  protected $description;

  /**
   * The weight of this outline in relation to other outlines.
   *
   * @var int
   */
  protected $weight = 0;

  /**
   * Default method of rendering outline entries.
   *
   * @var string
   */
  protected $render = Entry::RENDER_AS_DISPLAY;

  /**
   * Number of levels of the tree to show as expanded when opening.
   *
   * @var int
   */
  protected $expand_levels = 1;

  /**
   * Hide name field.
   *
   * @var boolean
   */
  protected $hide_name = TRUE;

  /**
   *  Hide Site entry.
   *
   * @var boolean
   */
  protected $hide_site;

  // @todo Add maximum number of levels and maximum number of entries.

  /**
   * The outline ID.
   *
   * @var string
   */
  protected $oid;

  /**
   * Root entry id field.
   *
   * @var integer
   */
  protected $root_entry_id;

  /**
   * Site entry id field.
   *
   * @var integer
   */
  protected $site_entry_id;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $values, $entity_type) {
    parent::__construct($values, $entity_type);
  }

  /**
   * {@inheritdoc}
   */
  public function getDescription() {
    return $this->description;
  }

  /**
   * {@inheritdoc}
   */
  public function getRender() {
    return $this->render;
  }

  /**
   * {@inheritdoc}
   */
  public function setRender($render) {
    $this->render = $render;
  }

  /**
   * {@inheritdoc}
   */
  public function getRenderName() {
    if ($this->getRender() == Entry::RENDER_AS_DISPLAY) {
      return Entry::RENDER_AS_DISPLAY_NAME;
    }
    elseif ($this->getRender() == Entry::RENDER_AS_FORM) {
      return Entry::RENDER_AS_FORM_NAME;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getExpandLevels() {
    return $this->expand_levels;
  }

  /**
   * {@inheritdoc}
   */
  public function setExpandLevels($expand_levels) {
    $this->expand_levels = $expand_levels;
  }

  /**
   * {@inheritdoc}
   */
  public function getHideName() {
    return $this->hide_name;
  }

  /**
   * {@inheritdoc}
   */
  public function setHideName($hideName) {
    $this->hide_name = $hideName;
  }

  /**
   * {@inheritdoc}
   */
  public function getHideSiteEntry() {
    return $this->hide_site;
  }

  /**
   * {@inheritdoc}
   */
  public function setHideSiteEntry($hide_site) {
    $this->hide_site = $hide_site;
  }

  /**
   * {@inheritdoc}
   */
  public function getRootEntryId() {

    if (empty($this->root_entry_id)) {

      // Create root entry.
      $entry_storage = \Drupal::entityTypeManager()
        ->getStorage('outline_entry');
      $values = ['name' => $this->label(), 'oid' => $this->id()];
      $root_entry = $entry_storage->create($values);
      $root_entry->save();
      $this->root_entry_id = $root_entry->id();

      // Create site entry.
      $values = [
        'name' => 'Site',
        'oid' => $this->id(),
        'parent' => $this->root_entry_id,
        'site' => TRUE,
      ];

      $site_entry = $entry_storage->create($values);
      $site_entry->save();
      $this->site_entry_id = $site_entry->id();

      // Save ids
      $this->save();
    }
    return $this->root_entry_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setRootEntryId($root_entry_id) {
    $this->root_entry_id = $root_entry_id;
  }

  /**
   * {@inheritdoc}
   */
  public function getRootEntry() {
    // Load entry.
    $entry = \Drupal::entityTypeManager()
      ->getStorage('outline_entry')
      ->load($this->getRootEntryId());
    return $entry;
  }

  /**
   * {@inheritdoc}
   */
  public function getSiteEntryId() {
    return $this->site_entry_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setSiteEntryId($site_entry_id) {
    $this->site_entry_id = $site_entry_id;
  }

  /**
   * {@inheritdoc}
   */
  public function getSiteEntry() {
    $entry = \Drupal::entityTypeManager()
      ->getStorage('outline_entry')
      ->load($this->getSiteEntryId());
    return $entry;
  }

  /**
   * {@inheritdoc}
   */
  public function id() {
    return $this->oid;
  }

  /**
   * {@inheritdoc}
   */
  public static function preDelete(EntityStorageInterface $storage, array $entities) {
    parent::preDelete($storage, $entities);

    // Only load Entries without a parent, child entries will get deleted too.
    //entity_delete_multiple('outline_entry', $storage->getToplevelEids(array_keys($entities),self::getRootEntryId()));
  }

  /**
   * {@inheritdoc}
   */
  public static function postDelete(EntityStorageInterface $storage, array $entities) {
    parent::postDelete($storage, $entities);

    // Reset caches.
    $storage->resetCache(array_keys($entities));

    if (reset($entities)->isSyncing()) {
      return;
    }

    $outlines = [];
    foreach ($entities as $outline) {
      $outlines[$outline->id()] = $outline->id();
    }
    // Load all Outline module fields and delete those which use only this
    // outline.
    $field_storages = \Drupal::entityTypeManager()
      ->getStorage('outline')
      ->loadByProperties(['module' => 'outline']);
    //$field_storages = entity_load_multiple_by_properties('field_storage_config', ['module' => 'outline']);
    foreach ($field_storages as $field_storage) {
      $modified_storage = FALSE;
      // Entry reference fields may reference entries from more than one outline.
      foreach ($field_storage->getSetting('allowed_values') as $key => $allowed_value) {
        if (isset($outlines[$allowed_value['outline']])) {
          $allowed_values = $field_storage->getSetting('allowed_values');
          unset($allowed_values[$key]);
          $field_storage->setSetting('allowed_values', $allowed_values);
          $modified_storage = TRUE;
        }
      }
      if ($modified_storage) {
        $allowed_values = $field_storage->getSetting('allowed_values');
        if (empty($allowed_values)) {
          $field_storage->delete();
        }
        else {
          // Update the field definition with the new allowed values.
          $field_storage->save();
        }
      }
    }
  }

  /**
   * Get the outline's top level entries.
   */
  public function getTopLevelEntries() {
    $top_level_eids = \Drupal::entityTypeManager()
      ->getStorage('outline')
      ->getToplevelEids(
        $this->id(),
        $this->getRootEntryId()
      );
    $top_level_entries = [];
    foreach ($top_level_eids as $eid) {
      $entry = \Drupal::entityTypeManager()
        ->getStorage('outline_entry')
        ->load($eid);
      if ($entry->isSite() && $this->getHideSiteEntry()) {
        continue;
      }
      else {
        $top_level_entries[] = $entry;
      }
    }
    return $top_level_entries;
  }

}
















///////////////////////////////////////////////////////////

  /**
   * Create a render array with enclosed unordered lists used to represent the
   * outline tree.
   *
   * <ul><li>Root Folder
   *   <ul>
   *      <li>Folder 1-1</li>
   *      <li>Folder 1-2
   *        <ul>
   *            <li>Folder 2-1</li>
   *            <li>Folder 2-2</li>
   *        </ul>
   *      </li>
   *  </ul>
   *
   *  $items['#theme' => 'item_list',
   *         '#items' => ['#markup' => 'Folder 1-1'],
   *                     ['#markup' => 'Folder 1-2',
   *                       'child_list' => ['#theme' => 'item_list',
   *                                        '#items' => ['#markup' => 'Folder
   * 2-1'],
   *
   *
   */
  /*
  public function outline_treexxxx() {
    $top_level_eids = static::entityTypeManager()
      ->getStorage('outline')
      ->getToplevelEids([
        $this->id(),
      ]);
    // kint($top_level_ids);
    $items = [];
    foreach ($top_level_eids as $eid) {
      $entry = static::entityTypeManager()
        ->getStorage('outline_entry')
        ->load($eid);
      $name = $entry->getName();
      $items [] = [
        '#markup' => $name,
      ];
    }
    // kint($items);
    $item_list = [
      '#prefix' => '<ul><li data-jstree="{ "opened" : true }">' . $this->label(),
      '#suffix' => '</li></ul>',
      '#theme' => 'item_list',
      '#items' => $items,
    ];
    // kint($item_list);  
    $output = [
      '#type' => 'container',
      '#attributes' => [
        'class' => [
          'outline-tree',
        ],
      ],
      'entries' => $item_list,
      '#attached' => [
        'library' => [
          'outline/drupal.outline.jstree',
          'outline/drupal.outline',
        ],
      ],
    ];
    // kint($output);
    return $output;
  }
*/

  /*
    public function outline_treezzzz() {
      $top_level_eids = static::entityTypeManager()
        ->getStorage('outline')
        ->getToplevelEids([
          $this->id(),
        ]);
      // kint($top_level_ids);
      $items = [];
      foreach ($top_level_eids as $eid) {
        $entry = static::entityTypeManager()
          ->getStorage('outline_entry')
          ->load($eid);
        $name = $entry->getName();
        $items [] = [
          '#markup' => $name,
        ];
      }
      // kint($items);
      $item_list = [
        '#prefix' => '<ul><li data-jstree="{ "opened" : true }">' . $this->label(),
        '#suffix' => '</li></ul>',
        '#theme' => 'item_list',
        '#items' => $items,
      ];
      // kint($item_list);
      $output = [
        '#type' => 'container',
        '#attributes' => [
          'class' => [
            'outline-tree',
          ],
        ],
        'entries' => $item_list,
        '#attached' => [
          'library' => [
            'outline/drupal.outline.jstree',
            'outline/drupal.outline',
          ],
        ],
      ];
      // kint($output);
      return $output;
    }
  */
  /**
   * Recursively build tree entries.
   */
  /*
   public function _outline_entry_tree(Array $entries) {
     $items = [];
     foreach ($entries as $entry) {
       $name = $entry->getName();
       if (empty($entry->childCount())) {
         $items [] = ['#markup' => $name];
       }
       else {
         _outline_entry_tree();
       }
     }
   }
 */

