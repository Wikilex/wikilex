<?php

namespace Drupal\wikilex_node\Entity;

use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\node\Entity\Node;
use Drupal\node\NodeInterface;

/**
 * Base for all nodes.
 */
class BaseNode extends Node {

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['created']->setDisplayConfigurable('view', TRUE);
    $fields['created']->setDisplayOptions(
      'view',
      [
        'label' => 'hidden',
        'type' => 'hidden',
        'weight' => 50,
      ]
    );

    return $fields;
  }

  /**
   * Renvoie une EntityQuery de base sur les nodes publiés.
   *
   * @return \Drupal\Core\Entity\Query\QueryInterface
   *   L'objet entity query.
   */
  public static function getEntityQuery() {
    $langcode = \Drupal::languageManager()->getCurrentLanguage()->getId();

    return \Drupal::entityQuery('node')
      ->condition('langcode', $langcode)
      ->condition('status', NodeInterface::PUBLISHED);
  }

}
