<?php

namespace Drupal\outline\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\Plugin\Field\FieldFormatter\EntityReferenceFormatterBase;

/**
 * Plugin implementation of the 'entity reference outline entry RSS' formatter.
 *
 * @FieldFormatter(
 *   id = "entity_reference_rss_category",
 *   label = @Translation("RSS category"),
 *   description = @Translation("Display reference to outline entry in RSS."),
 *   field_types = {
 *     "entity_reference"
 *   }
 * )
 */
class EntityReferenceOutlineEntryRssFormatter extends EntityReferenceFormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $parent_entity = $items->getEntity();
    $elements = array();

    foreach ($this->getEntitiesToView($items, $langcode) as $delta => $entity) {
      $parent_entity->rss_elements[] = array(
        'key' => 'category',
        'value' => $entity->label(),
        'attributes' => array(
          'domain' => $entity->id() ? \Drupal::url('entity.outline_entry.canonical', ['outline_entry' => $entity->id()], array('absolute' => TRUE)) : '',
        ),
      );
    }

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public static function isApplicable(FieldDefinitionInterface $field_definition) {
    // This formatter is only available for outline entries.
    return $field_definition->getFieldStorageDefinition()->getSetting('target_type') == 'outline_entry';
  }

}
