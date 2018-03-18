<?php

/**
 * @file
 * Contains \Drupal\backup_db\Form\BackupDatabaseHistoryForm.
 */

namespace Drupal\backup_db\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormBase;

/**
 * BackupDatabaseHistoryForm class.
 */
class BackupDatabaseHistoryForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'backup_db_history';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $rows = array()) {
    $header = array(
      'fid' => 'fid', 
      'name' => t('Name'), 
      'location' => t('Location'), 
      'created' => t('Created')
    );

    $form['table'] = array(
      '#type' => 'tableselect',
      '#header' => $header,
      '#options' => $rows,
      '#empty' => t('No local export history found.')
    );

    if ($rows) {
      $form['submit'] = array(
        '#type' => 'submit',
        '#value' => t('Delete'),
      );
    }

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();

    $files = array_filter($values['table']);
    foreach ($files as $file) {
      backup_db_history_delete($file);
    }
  }
}
