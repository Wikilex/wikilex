<?php


namespace Drupal\outline;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\outline\EntryInterface;

/**
 * Base for handler for outline entry edit forms.
 */
class EntryForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {

    $entry = $this->entity;
    $outline_storage = $this->entityManager->getStorage('outline');
    $outline = $outline_storage->load($entry->bundle());
    //$entry_storage = $this->entityManager->getStorage('outline_entry');
    $form_state->set(['outline', 'parent'],$entry->getParent());
    $form_state->set(['outline', 'outline'], $outline);

    // Settings
    $form['settings'] = [
      '#type' => 'details',
      '#title' => $this->t('Settings'),
      '#open' => FALSE,
      '#weight' => 30,
    ];

    // Weight
    $form['settings']['weight'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Weight'),
      '#size' => 6,
      '#default_value' => $entry->getWeight(),
      '#description' => $this->t('Terms are displayed in ascending order by weight.'),
      '#required' => TRUE,
      '#weight' => 40,
    ];

    // Site
    $form['settings']['site'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Site'),
      '#description' => $this->t('Site entry.'),
      '#disabled' => TRUE,
      '#weight' => 60,
    ];

    // Outline id.
    $form['oid'] = [
      '#type' => 'value',
      '#value' => $outline->id(),
    ];

    // Entry id.
    $form['eid'] = [
      '#type' => 'value',
      '#value' => $entry->id(),
    ];

    return parent::form($form, $form_state, $entry);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);

    // Ensure numeric values.
    if ($form_state->hasValue('weight') && !is_numeric($form_state->getValue('weight'))) {
      $form_state->setErrorByName('weight', $this->t('Weight value must be numeric.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function buildEntity(array $form, FormStateInterface $form_state) {
    $entry = parent::buildEntity($form, $form_state);

    // Prevent leading and trailing spaces in entry names.
    $entry->setName(trim($entry->getName()));

    return $entry;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entry = $this->entity;
    $result = $entry->save();

    $link = $entry->link($this->t('Edit'), 'edit-form');
    switch ($result) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created new entry %entry.', ['%entry' => $entry->getName()]));
        $this->logger('outline')
          ->notice('Created new entry %entry.', [
            '%entry' => $entry->getName(),
            'link' => $link,
          ]);
        break;
      case SAVED_UPDATED:
        drupal_set_message($this->t('Updated entry %entry.', ['%entry' => $entry->getName()]));
        $this->logger('outline')
          ->notice('Updated entry %entry.', [
            '%entry' => $entry->getName(),
            'link' => $link,
          ]);
        break;
    }

    $form_state->setValue('eid', $entry->id());
    $form_state->set('eid', $entry->id());
  }

}
