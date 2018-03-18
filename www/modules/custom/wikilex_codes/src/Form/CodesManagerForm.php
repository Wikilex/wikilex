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
class CodesManagerForm extends ConfigFormBase {

  /**
   * @inheritDoc
   */
  public function getFormId() {
    return 'wikilex_codes_manager';
  }

  /**
   * @inheritDoc
   */
  protected function getEditableConfigNames() {
    return [
      'wikilex_codes.manager',
    ];
  }

  public function buildForm(array $form, FormStateInterface $form_state, $cid = NULL){
    $config = $this->config('wikilex_codes.manager');
    $codes = $config->get('codes');
    $code = $codes[$cid];
    $form_state->set('cid', $cid);

    $form['#cache'] = ['max-age' => 0];
    $form['#tree'] = TRUE;
    $form['code_name'] = array(
      '#type' => 'textfield',
      '#title' => t('Nom du code'),
      '#size' => 60,
      '#default_value' => $code['code_name'],
      '#required' => TRUE,
    );
    $form['code_machine_name'] = array(
      '#type' => 'machine_name',
      '#maxlength' => 64,
      '#description' => $this->t('A unique name for this item. It must only contain lowercase letters, numbers, and underscores.'),
      '#machine_name' => array(
        'exists' => array($this, 'exists'),
        'source' => ['code_name'],
        'replace_pattern' => '[^a-z0-9-]+',
        'replace' => '_',
      ),
    );
    $form['code_cid'] = array(
      '#type' => 'textfield',
      '#title' => t('CID du code'),
      '#size' => 25,
      '#default_value' => $code['code_cid'],
      '#required' => TRUE,
    );

    $form['vocabulaires'] = array(
      '#type' => 'container',
      '#attributes' => ['id' => 'vocabulaires-ajax-wrapper'],
      'title-markup' => array(
        "#type" => 'html_tag',
        '#tag' => 'h2',
        '#value' => $this->t("Liste des Vocabulaires de taxonomie du Code."),
      ),
    );

    $form['vocabulaires']['vocabulaire_add'] = array(
      '#type' => 'submit',
      '#value' => t('Ajouter un vocabulaire en plus'),
      '#submit' => array('::VocabulaireAddOne'),
      '#ajax' => array(
        'callback' => '::VocabulaireAddOneCallback',
        'wrapper' => 'vocabulaires-ajax-wrapper',
      ),
      '#weight' => 100,
      '#attributes' => array(
        'class' => array('button button-action button--success'),
      ),
    );

    $vocabulaires = [];
    if(!empty($code['vocabulaires'])) {
      $vocabulaires = $code['vocabulaires'];
    }
    $voc_count = count($vocabulaires) > 1 ? count($vocabulaires) : 1;

     // On initialise le compteur.
    if ($form_state->get('vocabulaires_deltas') == '') {
      $form_state->set('vocabulaires_deltas', range(0, $voc_count));
    }
    $deltas = $form_state->get('vocabulaires_deltas');

    foreach ($deltas as $key) {
      $vocabulaire_name = isset($vocabulaires[$key]['vocabulaire_name']) ? $vocabulaires[$key]['vocabulaire_name'] : '';
      $vocabulaire_machine_name = isset($vocabulaires[$key]['vocabulaire_machine_name']) ? $vocabulaires[$key]['vocabulaire_machine_name'] : '';
      $vocabulaire_description = isset($vocabulaires[$key]['vocabulaire_description']) ? $vocabulaires[$key]['vocabulaire_description'] : '';

      $form['vocabulaires'][$key] = array(
        '#type' => 'fieldset',
        '#attributes' => array(
          'class' => array('container-vocabulaires'),
        ),
        '#tree' => TRUE,
      );

      $form['vocabulaires'][$key]['vocabulaire_name'] = array(
        '#type' => 'textfield',
        '#title' => t('Nom du vocabulaire'),
        '#size' => 35,
        '#default_value' => $vocabulaire_name,
      );

      $form['vocabulaires'][$key]['vocabulaire_machine_name'] = array(
        '#type' => 'textfield',
        '#title' => t('Nom système du vocabulaire'),
        '#description' => $this->t('A unique name for this item. It must only contain lowercase letters, numbers, and underscores.'),
        '#size' => 35,
        '#default_value' => $vocabulaire_machine_name,
      );
      $form['vocabulaires'][$key]['vocabulaire_description'] = array(
        '#type' => 'textfield',
        '#title' => t('Description du vocabulaire'),
        '#size' => 65,
        '#default_value' => $vocabulaire_description,
      );

      $form['vocabulaires'][$key]['vocabulaire_remove'] = array(
        '#type' => 'submit',
        '#value' => t('Supprimer le vocabulaire'),
        '#submit' => array('::VocabulaireRemove'),
        '#ajax' => array(
          'callback' => '::VocabulaireRemoveCallback',
          'wrapper' => 'vocabulaires-ajax-wrapper',
        ),
        '#weight' => 50,
        '#attributes' => array(
          'class' => array('button-small button button-action button-wikilex-danger'),
        ),
        '#name' => 'vocabulaire_remove_' . $key,
      );
    }
   
    return parent::buildForm($form, $form_state);

  }


  
  /************* DEBUT DU AJAX pour les directories *********/
  
  /**
   * @param array $form
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   */
  function VocabulaireRemove(array &$form, FormStateInterface $form_state) {
    // Get the triggering item
    $delta_remove = $form_state->getTriggeringElement()['#parents'][1];

    // Store our form state
    $vocabulaires_deltas_array = $form_state->get('vocabulaires_deltas');

    // Find the key of the item we need to remove
    $key_to_remove = array_search($delta_remove, $vocabulaires_deltas_array);

    // Remove our triggered element
    unset($vocabulaires_deltas_array[$key_to_remove]);

    // Rebuild the field deltas values
    $form_state->set('vocabulaires_deltas', $vocabulaires_deltas_array);

    // Rebuild the form
    $form_state->setRebuild();

    // Return any messages set
    //drupal_get_messages('Le champ répertoire -' . $key_to_remove . ' a été supprimé.');
  }

  /**
   * Le callback du remove. Il est lié au wrapper sélectionné par le bouton remove.
   */
  function VocabulaireRemoveCallback(array &$form, FormStateInterface $form_state) {
    return $form['vocabulaires'];
  }
  

  /**
   * @param array $form
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   */
  function VocabulaireAddOne(array &$form, FormStateInterface $form_state) {

    // Stock le counter delta à partir de la form state.
    $vocabulaires_deltas_array = $form_state->get('vocabulaires_deltas');

    // check to see if there is more than one item in our array
    if (count($vocabulaires_deltas_array) > 0) {
      // Add a new element to our array and set it to our highest value plus one
      $vocabulaires_deltas_array[] = max($vocabulaires_deltas_array) + 1;
    }
    else {
      // Set the new array element to 0
      $vocabulaires_deltas_array[] = 0;
    }

    // Rebuild the field deltas values
    $form_state->set('vocabulaires_deltas', $vocabulaires_deltas_array);

    // Rebuild the form
    $form_state->setRebuild();

    // Return any messages set
    //drupal_get_messages();
  }

  /**
   * Le callback du remove. Il est lié au wrapper sélectionné par le bouton remove.
   */
  function VocabulaireAddOneCallback(array &$form, FormStateInterface $form_state) {
    return $form['vocabulaires'];
  }
  
  
  
  
  /************* FIN DU AJAX *********/

  // TODO Validate vérifier que le nom et cid n'existe pas déjà, et que les deux champs sont remplis.
  // TODO Sassurer que le champ machine name est bien au format machine name.
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
    
    $values = $form_state->getValues();
    $config = $this->config('wikilex_codes.manager');
    $codes = $config->get('codes');
    $cid = $form_state->get('cid');
    $code = $codes[$cid];
    $vocabulaires = [];

    if(is_array($values) && !empty($values['code_name']) && !empty($values['code_cid'])){
      $code['code_name'] = $values['code_name'];
      $code['code_cid'] = $values['code_cid'];
    }


    foreach ($values['vocabulaires'] as $key => $value) {
      if(is_array($value) && !empty($value['vocabulaire_name'])){
        $vocabulaire['vocabulaire_name'] = $value['vocabulaire_name'];
      }
      if(is_array($value) && !empty($value['vocabulaire_machine_name'])){
        $vocabulaire['vocabulaire_machine_name'] = $value['vocabulaire_machine_name'];
      }
      if(is_array($value) && !empty($value['vocabulaire_description'])){
        $vocabulaire['vocabulaire_description'] = $value['vocabulaire_description'];
        $vocabulaires[] = $vocabulaire;
      }
    }

    $code['vocabulaires'] = $vocabulaires;

    // TODO : Gérer le changement de cid, et sa réecriture.
    $codes[$cid] = $code;
    \Drupal::configFactory()->getEditable('wikilex_codes.manager')
      // Set the submitted configuration setting
      ->set('codes', $codes)
      ->save();

    drupal_set_message(t('La structure du code de lois a été sauvegardée.'));
    parent::submitForm($form, $form_state);


  }

}