<?php

namespace Drupal\outline;

use Drupal\Core\Entity\ContentEntityTypeInterface;
use Drupal\Core\Entity\Sql\SqlContentEntityStorageSchema;
use Drupal\Core\Field\FieldStorageDefinitionInterface;

/**
 * Defines the entry schema handler.
 */
class EntryStorageSchema extends SqlContentEntityStorageSchema {

  /**
   * {@inheritdoc}
   */
  protected function getEntitySchema(ContentEntityTypeInterface $entity_type, $reset = FALSE) {
    $schema = parent::getEntitySchema($entity_type, $reset = FALSE);

    $schema['outline_entry_field_data']['indexes'] += array(
      'outline_entry__tree' => array('oid', 'weight', 'name'),
      'outline_entry__oid_name' => array('oid', 'name'),
    );
//     $schema['outline_entry_field_data']['indexes'][] = array(
//         'outline_entry__tree' => array('oid', 'weight', 'name'),
//         'outline_entry__oid_name' => array('oid', 'name'),
//     );

    $schema['outline_index'] = array(
      'description' => 'Maintains denormalized information about node/entry relationships.',
      'fields' => array(
        'nid' => array(
          'description' => 'The {node}.nid this record tracks.',
          'type' => 'int',
          'unsigned' => TRUE,
          'not null' => TRUE,
          'default' => 0,
        ),
        'eid' => array(
          'description' => 'The entry ID.',
          'type' => 'int',
          'unsigned' => TRUE,
          'not null' => TRUE,
          'default' => 0,
        ),
        'status' => array(
          'description' => 'Boolean indicating whether the node is published (visible to non-administrators).',
          'type' => 'int',
          'not null' => TRUE,
          'default' => 1,
        ),
        'sticky' => array(
          'description' => 'Boolean indicating whether the node is sticky.',
          'type' => 'int',
          'not null' => FALSE,
          'default' => 0,
          'size' => 'tiny',
        ),
        'created' => array(
          'description' => 'The Unix timestamp when the node was created.',
          'type' => 'int',
          'not null' => TRUE,
          'default' => 0,
        ),
      ),
      'primary key' => array('nid', 'eid'),
      'indexes' => array(
        'entry_node' => array('eid', 'status', 'sticky', 'created'),
      ),
      'foreign keys' => array(
        'tracked_node' => array(
          'table' => 'node',
          'columns' => array('nid' => 'nid'),
        ),
        'outline_entry' => array(
          'table' => 'outline_entry_data',
          'columns' => array('eid' => 'eid'),
        ),
      ),
    );

    return $schema;
  }

  /**
   * {@inheritdoc}
   */
  protected function getSharedTableFieldSchema(FieldStorageDefinitionInterface $storage_definition, $table_name, array $column_mapping) {
    $schema = parent::getSharedTableFieldSchema($storage_definition, $table_name, $column_mapping);
    $field_name = $storage_definition->getName();

    if ($table_name == 'outline_entry_field_data') {
      // Remove unneeded indexes.
      unset($schema['indexes']['outline_entry_field__oid__target_id']);
      unset($schema['indexes']['outline_entry_field__description__format']);

      switch ($field_name) {
        case 'weight':
          // Improves the performance of the outline_entry__tree index defined
          // in getEntitySchema().
          $schema['fields'][$field_name]['not null'] = TRUE;
          break;

        case 'name':
          $this->addSharedTableFieldIndex($storage_definition, $schema, TRUE);
          break;
      }
    }

    return $schema;
  }

}
