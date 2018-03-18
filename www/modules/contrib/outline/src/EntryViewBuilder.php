<?php

namespace Drupal\outline;

use Drupal\Core\Entity\Display\EntityViewDisplayInterface;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityViewBuilder;

/**
 * View builder handler for outline entries.
 */
class EntryViewBuilder extends EntityViewBuilder {

  /**
   * {@inheritdoc}
   */
  protected function alterBuild(array &$build, EntityInterface $entity, EntityViewDisplayInterface $display, $view_mode) {
    parent::alterBuild($build, $entity, $display, $view_mode);
    $build['#contextual_links']['outline_entry'] = array(
      'route_parameters' => array('outline_entry' => $entity->id()),
      'metadata' => array('changed' => $entity->getChangedTime()),
    );
  }

}
