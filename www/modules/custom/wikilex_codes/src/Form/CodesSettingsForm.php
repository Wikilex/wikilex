<?php
/**
 * @file
 * Contains \Drupal\wikilex_codes\Form\YMLMakerSettingsForm
 */
namespace Drupal\wikilex_codes\Form;


use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;


/**
 * Manage Settings for the YML Maker module
 */
class CodesSettingsForm extends ConfigFormBase {

  /**
   * @inheritDoc
   */
  public function getFormId() {
    return 'wikilex_codes_admin_settings';
  }

  /**
   * @inheritDoc
   */
  protected function getEditableConfigNames() {
    return [
      'wikilex_codes.settings',
    ];
  }

  public function buildForm(array $form, FormStateInterface $form_state){
    $config = $this->config('wikilex_codes.settings');


    // TODO : Option boolèenne pour ajouter automatiquement le cid aux machines names des vocabulaires
    // TODO : Option pour ajouter automatiquement le vocabulaire thematique à la création du code.
    return parent::buildForm($form, $form_state);

  }



  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Submit Form
    $values = $form_state->getValues();

    // TODO : S'occupper de la sauveguarde des options de configuration.

    drupal_set_message(t('Les options de configuration pour Wikilex Codes ont été sauvegardées.'));
    parent::submitForm($form, $form_state);


  }

}