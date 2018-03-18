<?php

namespace Drupal\outline\Plugin\EntityReferenceSelection;

use Drupal\Component\Utility\Html;
use Drupal\Core\Database\Query\SelectInterface;
use Drupal\Core\Entity\Plugin\EntityReferenceSelection\DefaultSelection;
use Drupal\Core\Form\FormStateInterface;
use Drupal\outline\Entity\Outline;

/**
 * Provides specific access control for the outline_entry entity type.
 *
 * @EntityReferenceSelection(
 *   id = "default:outline_entry",
 *   label = @Translation("Outline Entry selection"),
 *   entity_types = {"outline_entry"},
 *   group = "default",
 *   weight = 1
 * )
 */
class EntrySelection extends DefaultSelection {

  /**
   * {@inheritdoc}
   */
  public function entityQueryAlter(SelectInterface $query) {
    // @todo: How to set access, as outline is now config?
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildConfigurationForm($form, $form_state);

    $form['target_bundles']['#title'] = $this->t('Available Outlines');

    // Sorting is not possible for outline entries because we use
    // \Drupal\outline\EntryStorageInterface::loadTree() to retrieve matches.
    $form['sort']['#access'] = FALSE;

    return $form;

  }

  /**
   * {@inheritdoc}
   */
  public function getReferenceableEntities($match = NULL, $match_operator = 'CONTAINS', $limit = 0) {
    if ($match || $limit) {
      return parent::getReferenceableEntities($match, $match_operator, $limit);
    }

    $options = array();

    $bundles = $this->entityManager->getBundleInfo('outline_entry');
    $handler_settings = $this->configuration['handler_settings'];
    $bundle_names = !empty($handler_settings['target_bundles']) ? $handler_settings['target_bundles'] : array_keys($bundles);

    foreach ($bundle_names as $bundle) {
      if ($outline = Outline::load($bundle)) {
        if ($entries = $this->entityManager->getStorage('outline_entry')->loadTree($outline->id(), 0, NULL, TRUE)) {
          foreach ($entries as $entry) {
            $options[$outline->id()][$entry->id()] = str_repeat('-', $entry->depth) . Html::escape($this->entityManager->getTranslationFromContext($entry)->label());
          }
        }
      }
    }

    return $options;
  }

}
