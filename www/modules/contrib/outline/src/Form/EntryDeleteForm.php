<?php

namespace Drupal\outline\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Entity\ContentEntityDeleteForm;
use Drupal\Core\Url;

/**
 * Provides a deletion confirmation form for outline entry.
 */
class EntryDeleteForm extends ContentEntityDeleteForm {

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    // The cancel URL is the outline collection, entries have no global
    // list page.
    return new Url('entity.outline.collection');
  }

  /**
   * {@inheritdoc}
   */
  protected function getRedirectUrl() {
    return $this->getCancelUrl();
  }

  /**
   * {@inheritdoc}
   */
  public function getDescription() {
    return $this->t('Deleting an entry will delete all its children if there are any. This action cannot be undone.');
  }

  /**
   * {@inheritdoc}
   */
  protected function getDeletionMessage() {
    return $this->t('Deleted entry %name.', array('%name' => $this->entity->label()));
  }

  /**
   * {@inheritdoc}
   */
//  public function submitForm(array &$form, FormStateInterface $form_state) {
//    parent::submitForm($form, $form_state);
//
//    /** @var \Drupal\Core\Entity\ContentEntityInterface $entry */
//    $entry = $this->getEntity();
//    if ($entry->isDefaultTranslation()) {
//      $storage = $this->entityManager->getStorage('outline');
//      $outline = $storage->load($this->entity->bundle());
//
//      // @todo Move to storage http://drupal.org/node/1988712
//      outline_check_outline_hierarchy($outline, array('eid' => $entry->id()));
//    }
//  }

}
