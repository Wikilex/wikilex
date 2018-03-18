<?php

namespace Drupal\wikilex_hook_book\Form;

// Classes referenced in this class:
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfigFormBase;

// This is the form we are extending
use Drupal\book\Form\BookSettingsForm;

/**
 * Configure site information settings for this site.
 */
class CustomBookSettingsForm extends BookSettingsForm {


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'custom_book_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return parent::getEditableConfigNames();
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $types = node_type_get_names();
    $config = $this->config('book.settings');

    // Get the original form from the class we are extending
    $form = parent::buildForm($form, $form_state);

    $display_tree = $config->get('display_tree');
    $form['book_display_tree'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Content types allowed to display the Outline Tree'),
      '#default_value' => ($display_tree) ? $display_tree : [],
      '#options' => $types,
      '#description' => $this->t('Users with the %outline-perm permission can add all content types.', ['%outline-perm' => $this->t('Administer book outlines')]),
      '#required' => FALSE,
    ];

    $display_outline_links = $config->get('display_outline_links');
    $form['book_display_outline_links'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Content types allowed to display Outline Navigation links'),
      '#default_value' => ($display_outline_links) ? $display_outline_links : [],
      '#options' => $types,
      '#description' => $this->t('Users with the %outline-perm permission can add all content types.', ['%outline-perm' => $this->t('Administer book outlines')]),
      '#required' => FALSE,
    ];


    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $display_tree = $form_state->getValue('book_display_tree');
    foreach ($display_tree as $option) {
      if (!empty($option) && $form_state->isValueEmpty(['book_allowed_types', $option])) {
        $form_state->setErrorByName('book_display_tree', $this->t('The content types for the Display tree option must be one of those selected as an allowed book outline type.'));
      }
    }

    $display_outline_links = $form_state->getValue('book_display_outline_links');
    foreach ($display_outline_links as $option) {
      if (!empty($option) && $form_state->isValueEmpty(['book_allowed_types', $option])) {
        $form_state->setErrorByName('book_display_outline_links', $this->t('The content types for the Display Outline links option must be one of those selected as an allowed book outline type.'));
      }
    }
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);
    $display_tree = array_filter($form_state->getValue('book_display_tree'));
    $display_outline_links= array_filter($form_state->getValue('book_display_outline_links'));
    // We need to save the two new options in an array ordered by machine_name so
    // that we can save them in the correct order if node type changes.
    // @see book_node_type_update().
    sort($display_tree);
    sort($display_outline_links);
    $config = $this->config('book.settings');
     $config->set('display_tree', $display_tree)
      ->set('display_outline_links', $display_outline_links)
      ->save();
  }
}