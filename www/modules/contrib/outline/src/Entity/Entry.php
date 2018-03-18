<?php

namespace Drupal\outline\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\outline\EntryInterface;

/**
 * Defines the outline entry entity.
 *
 * @ContentEntityType(
 *   id = "outline_entry",
 *   label = @Translation("Outline entry"),
 *   bundle_label = @Translation("Outline"),
 *   handlers = {
 *     "storage" = "Drupal\outline\EntryStorage",
 *     "storage_schema" = "Drupal\outline\EntryStorageSchema",
 *     "view_builder" = "Drupal\outline\EntryViewBuilder",
 *     "access" = "Drupal\outline\EntryAccessControlHandler",
 *     "views_data" = "Drupal\outline\EntryViewsData",
 *     "form" = {
 *       "default" = "Drupal\outline\EntryForm",
 *       "delete" = "Drupal\outline\Form\EntryDeleteForm"
 *     },
 *     "translation" = "Drupal\outline\EntryTranslationHandler"
 *   },
 *   base_table = "outline_entry_data",
 *   data_table = "outline_entry_field_data",
 *   uri_callback = "outline_entry_uri",
 *   translatable = TRUE,
 *   entity_keys = {
 *     "id" = "eid",
 *     "bundle" = "oid",
 *     "label" = "name",
 *     "langcode" = "langcode",
 *     "uuid" = "uuid"
 *   },
 *   bundle_entity_type = "outline",
 *   common_reference_target = TRUE,
 *   links = {
 *     "canonical" = "/outline/outline_entry/{entry}",
 *     "delete-form" = "/outline/outline_entry/{entry}/delete",
 *     "edit-form" = "/outline/outline_entry/{entry}/edit",
 *   },
 *   permission_granularity = "bundle"
 * )
 */
class Entry extends ContentEntityBase implements EntryInterface {

  use EntityChangedTrait;

  //@todo rename to DISPLAY_CONTEXT ??
  const RENDER_AS_DISPLAY = 0;

  const RENDER_AS_FORM = 1;

  const RENDER_AS_DISPLAY_NAME = 'display';

  const RENDER_AS_FORM_NAME = 'form';

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {

    // ID
    $fields['eid'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Entry ID'))
      ->setDescription(t('The entry ID.'))
      ->setReadOnly(TRUE)
      ->setSetting('unsigned', TRUE);

    // Name
    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setTranslatable(TRUE)
      ->setRequired(TRUE)
      ->setSetting('max_length', 255)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'string',
        'weight' => -5,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -5,
      ])
      ->setDisplayConfigurable('form', TRUE);

    // Content
    $fields['content'] = BaseFieldDefinition::create('text_long')
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'text_default',
        'weight' => 0,
      ])
      ->setDisplayConfigurable('view', TRUE)
      ->setDisplayOptions('form', [
        'type' => 'text_textfield',
        'weight' => 0,
      ])
      ->setDisplayConfigurable('form', TRUE);

    // Dynamic Entity Reference
    $fields['entity'] = BaseFieldDefinition::create('dynamic_entity_reference')
      ->setLabel(t('Entity'))
      ->setDescription(t('An entity attached to this outline entry.'))
      ->setSetting('target_type', ['node', 'outline_entry', 'user'])
      ->setDisplayOptions('form', [
        'type' => 'dynamic_entity_reference_default',
        'weight' => 20,
      ]);

    // Weight
    $fields['weight'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Weight_e'))
      ->setDescription(t('The weight of this entry in relation to other entries.'))
      ->setDefaultValue(0);

    // Expanded
    $fields['expanded'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Expanded'))
      ->setDescription(t('Expand entry.'));

    // Disabled
    $fields['disabled'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Disabled'))
      ->setDescription(t('Disable entry.'));

    // Changed
    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entry was last edited.'))
      ->setTranslatable(TRUE);

    // Parent Reference
    $fields['parent'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Entry Parent'))
      ->setDescription(t('The parent of this entry.'))
      ->setSetting('target_type', 'outline_entry');
     // ->setCustomStorage(TRUE);

    // Outline Reference
    $fields['oid'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Outline'))
      ->setDescription(t('The outline to which the entry is assigned.'))
      ->setSetting('target_type', 'outline');

    // UUID
    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setDescription(t('The entry UUID.'))
      ->setReadOnly(TRUE);

    // Langcode
    $fields['langcode'] = BaseFieldDefinition::create('language')
      ->setLabel(t('Language'))
      ->setDescription(t('The entry language code.'))
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', [
        'type' => 'hidden',
      ])
      ->setDisplayOptions('form', [
        'type' => 'language_select',
        'weight' => 2,
      ]);

    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return $this->label();
  }

  /**
   * {@inheritdoc}
   */
  public function setName($name) {
    $this->set('name', $name);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getContent() {
    return $this->get('content')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setContent($content) {
    $this->set('content', $content);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getFormat() {
    return $this->get('content')->format;
  }

  /**
   * {@inheritdoc}
   */
  public function setFormat($format) {
    $this->get('content')->format = $format;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getWeight() {
    return $this->get('weight')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setWeight($weight) {
    $this->set('weight', $weight);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getDisabled() {
    return $this->get('disabled')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setDisabled($disabled) {
    $this->set('disabled', $disabled);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getExpanded() {
    return $this->get('expanded')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setExpanded($expanded) {
    $this->set('expanded', $expanded);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getOutlineId() {
    return $this->get('oid')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function getOutline() {
    $outline = \Drupal::entityTypeManager()
      ->getStorage('outline')
      ->load($this->getOutlineId());
    return $outline;
  }

  /**
   * {@inheritdoc}
   */
  public function getCalcEntityId() {
    $derField = $this->get('entity');
    $values = $derField[0]->getValue();

    if (empty($values['target_id'])) {
      $entityId = $this->id();
    }
    else {
      $entityId = $values['target_id'];
    }
    return $entityId;
  }

  /**
   * {@inheritdoc}
   */
  public function getCalcEntityType() {
    $derField = $this->get('entity');
    $values = $derField[0]->getValue();

    if (empty($values['target_type'])) {
      $entityType = 'outline_entry';
    }
    else {
      $entityType = $values['target_type'];
    }
    return $entityType;
  }

  /**
   * {@inheritdoc}
   */
  public function getCalcEntityMode() {
    return $this::RENDER_AS_DISPLAY;
  }

  /**
   * {@inheritdoc}
   */
  public function getCalcEntityDisplay() {
    return "full";
  }

  /**
   * {@inheritdoc}
   */
  public function getCalcEntityEditUrl() {
    $derField = $this->get('entity');
    $values = $derField[0]->getValue();

    if (empty($values['target_type'])) {
      return $this->toUrl('edit-form')->toString();
    }
    else {
      $entityType = $values['target_type'];
      $entityId = $values['target_id'];
      $entity = static::entityTypeManager()
        ->getStorage($entityType)
        ->load($entityId);
      return $entity->toUrl('edit-form')->toString();
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getCalcEntryType() {
    if ($this->isRoot()) {
      return 'root';
    }
    elseif ($this->isSite()) {
      return 'site';
    }
    else {
      return 'default';
    }
  }

  /**
   * {@inheritdoc}
   */
  public function isRoot() {
    $parent = $this->get('parent')->target_id;
    if (empty($parent)) {
      return TRUE;
    }
    else {
      return FALSE;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function isSite() {
    return ($this ===  $this->getOutline()->getSiteEntry() || $this->hasParent($this->getOutline()->getSiteEntry()));
  }

  /**
   * {@inheritdoc}
   */
  public function getChildren() {
    $children = static::entityTypeManager()
      ->getStorage('outline_entry')
      ->loadChildren($this->id());
    return $children;
  }

  /**
   * {@inheritdoc}
   */
  public function getParent() {
    if ($this->isRoot()) {
      return NULL;
    }
    else {
      $parent_id = $this->get('parent')->target_id;
      $parent = static::entityTypeManager()
        ->getStorage('outline_entry')
        ->load($parent_id);
      return $parent;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function getAllParents() {
    $parents = [];
    $parent = $this->getParent();
    while (!empty($parent)) {
      $parents[] =  $parent;
      $parent = $parent->getParent();
    }
    return $parents;
  }

  /**
   * {@inheritdoc}
   */
  public function hasParent($entry) {
    $all_parents = $this->getAllParents();
    return in_array($entry, $all_parents );
  }

  /**
   * {@inheritdoc}
   */
  public static function postDelete(EntityStorageInterface $storage, array $entities) {
    parent::postDelete($storage, $entities);

    // Delete the entry's children.
    foreach (array_keys($entities) as $eid) {
      if ($children = $storage->loadChildren($eid)) {
        foreach ($children as $child) {
          $children_delete[] = $child->id();
        }
      }
    }

    //$storage->deleteEntryHierarchy(array_keys($entities));

    // Delete the entry's children.
    if (!empty($children_delete)) {
      entity_delete_multiple('outline_entry', $children_delete);
    }
  }

  /**
   * {@inheritdoc}
   */
  public function postSave(EntityStorageInterface $storage, $update = TRUE) {
    parent::postSave($storage, $update);
    // Synchronize root entry name and outline name.
    if ($this->isRoot()) {
      $outline = $this->getOutline();
      $outline->set('name', $this->get('name')->value);
      $outline->save();
    }
  }

}