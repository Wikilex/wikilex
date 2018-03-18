<?php
/**
 * @file
 * Contains \Drupal\wikilex_codes\Form\DeleteForm
 */
namespace Drupal\wikilex_codes\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Url;
use Drupal\Core\Render\Element;

/**
 * Class DeleteForm
 *
 * @package Drupal\wikilex_codes\Form
 */

class DeleteCodeForm extends ConfirmFormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'wikilex_codes_delete_form';
  }
  
  public $cid;
  public $name;
  
  public function getQuestion() {
    return t('Do you want to delete %name?', array('%name' => $this->name));
  }
  public function getCancelUrl() {
    return new Url('wikilex_codes.list');
  }
  public function getDescription() {
    return t('Only do this if you are sure!');
  }
  /**
   * {@inheritdoc}
   */
  public function getConfirmText() {
    return t('Delete it!');
  }
  /**
   * {@inheritdoc}
   */
  public function getCancelText() {
    return t('Cancel');
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $cid = NULL) {
    $config = $this->config('wikilex_codes.manager');
    $codes = $config->get('codes');

    if(empty($codes[$cid])){
      $form_state->setErrorByName('Id', t('Aucun code trouvé pour ce CID : %CID', array('%CID' => $cid)));

    }
    $this->cid = $cid;
    $this->name = $codes[$cid]['code_name'];
    $form_state->set('cid', $cid);
    return parent::buildForm($form, $form_state);
  }
  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('wikilex_codes.manager');
    $codes = $config->get('codes');
    $cid = $form_state->get('cid');
    unset($codes[$cid]);

    \Drupal::configFactory()->getEditable('wikilex_codes.manager')
      // Set the submitted configuration setting
      ->set('codes', $codes)
      ->save();

    drupal_set_message("Code effacé");
    $form_state->setRedirect('wikilex_codes.list');
  }
}