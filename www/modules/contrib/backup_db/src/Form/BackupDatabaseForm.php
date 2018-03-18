<?php

/**
 * @file
 * Contains \Drupal\backup_db\Form\BackupDatabaseForm.
 */

namespace Drupal\backup_db\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormBase;

use Drupal\backup_db\Adapter\BackupDatabaseLocalAdapter;
use Drupal\backup_db\Adapter\BackupDatabaseRemoteAdapter;
use Drupal\backup_db\Adapter\BackupDatabaseS3Adapter;

/**
 * BackupDatabaseForm class.
 */
class BackupDatabaseForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'backup_db_export';
  }

  /**
   * {@inheritdoc}
   *
   * @todo, displays last backup timestamp
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('backup_db.settings');
    $site_name = \Drupal::config('system.site')->get('name');

    // General.
    $form['filename'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Filename'),
      '#description' => $this->t('The prefix name of the sql dump file.'),
      '#default_value' => $config->get('filename') ? $config->get('filename') : $site_name
    );
    $form['type'] = array(
      '#type' => 'radios',
      '#title' => $this->t('Export type'),
      '#options' => array(
        'local' => $this->t('Local'),
        'download' => $this->t('Download')
        // 'aws' => $this->t('AWS S3')
      ),
      '#description' => $this->t('Export backup to local server or download.'),
      '#default_value' => 'download'
    );

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Export'),
      '#button_type' => 'primary',
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();

    // Save filename.
    \Drupal::configFactory()->getEditable('backup_db.settings')
      ->set('filename', $values['filename'])
      ->save();

    // Call backup_db client.
    $client = \Drupal::service('backup_db.client');

    // Select our adapter.
    if ($values['type'] == 'download') {
      $handler = new BackupDatabaseRemoteAdapter($client);
    }

    if ($values['type'] == 'local') {
      $handler = new BackupDatabaseLocalAdapter($client);
    }

    // Run the export.
    if ($handler->export()) {
      drupal_set_message(t('Backup has been successfully completed.'), 'status');
    }
    else {
      drupal_set_message(t('Backup has failed, please review recent log messages.'), 'warning');
    }
  }
}
