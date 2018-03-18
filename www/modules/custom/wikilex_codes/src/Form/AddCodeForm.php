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
class AddCodeForm extends ConfigFormBase {

  /**
   * @inheritDoc
   */
  public function getFormId() {
    return 'wikilex_codes_add_code';
  }

  /**
   * @inheritDoc
   */
  protected function getEditableConfigNames() {
    return [
      'wikilex_codes.manager',
    ];
  }

  public function buildForm(array $form, FormStateInterface $form_state){
    $form['code_name'] = array(
      '#type' => 'textfield',
      '#title' => t('Nom du code'),
      '#size' => 60,
    );
    $form['code_cid'] = array(
      '#type' => 'textfield',
      '#title' => t('CID du code'),
      '#size' => 25,
    );

    return parent::buildForm($form, $form_state);

  }

  // TODO Validate vérifier que le nom et cid n'existe pas déjà, et que les deux champs sont remplis.
  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // $config = $this->config('wikilex_codes.manager');
    parent::validateForm($form, $form_state);
  }


  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('wikilex_codes.manager');
    $codes = $config->get('codes');

    $values = $form_state->getValues();


    if(is_array($values) && !empty($values['code_name']) && !empty($values['code_cid'])){
        $code['code_name'] = $values['code_name'];
        $code['code_cid'] = $values['code_cid'];
        $code['vocabulaires'] = [];
        $code['vocabulaires'][] = [
          'vocabulaire_name' => "Thématiques " . $values['code_cid'],
          'vocabulaire_machine_name' => $values['code_cid'] . '_thematiques',
          'vocabulaire_description' => 'Liste des thématiques de ce code de loi'
        ];
    }

    $codes[$values['code_cid']] = $code;
    \Drupal::configFactory()->getEditable('wikilex_codes.manager')
      // Set the submitted configuration setting
      ->set('codes', $codes)
      ->save();

    drupal_set_message(t('Le code de loi a été créé.'));
    parent::submitForm($form, $form_state);
     $form_state->setRedirect('wikilex_codes.list');

  }

}