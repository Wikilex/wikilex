<?php
/**
 * @file
 * Contains \Drupal\wikilex_codes\Controller\CodesListController.
 */
namespace Drupal\wikilex_codes\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;

/**
 * Controller for Codes List
 */
class CodesListController extends ControllerBase {


  /**
   * Creates the List page.
   *
   * @return array
   *  Render array for List output.
   */
  public function build() {

    $config = $this->config('wikilex_codes.manager');
    $codes = $config->get('codes');
    $content = array();
    $class_action = array('class' => array('button button-action button--primary',));

    $content['actions'] = array('#type' => 'actions',);
    $content['actions']['#attributes'] = array('class' => array('action-links'));
    $content['actions']['add'] = array(
      '#type' => 'link',
      '#title' => t('Ajouter un code'),
      '#url' => Url::fromRoute('wikilex_codes.add_code'),
      '#attributes' => $class_action,
    );

    $content['message'] = array(
      "#type" => 'html_tag',
      '#tag' => 'h2',
      '#value' => $this->t("Liste des Codes Wikilex."),
    );

    $headers = array(
      t('Nom du Code'),
      t('Identifiant (CID)'),
      t('Vocabulaires'),
      t('Actions'),
      t('Actions'),
    );
    $rows = array();
    $content['table'] = array(
      '#type' => 'table',
      '#header' => $headers,
      //'#rows' => $rows,
      '#empty' => t('No entries available.'),
    );

    foreach ($codes as $cid => $code) {
      
      // Sanitize each entry.
      $content['table'][$cid]['name'] = array(
        "#type" => 'html_tag',
        '#tag' => 'p',
        '#value' => $this->t("%name", ['%name' => $code['code_name']]),
      );
      $content['table'][$cid]['cid'] = array(
        "#type" => 'html_tag',
        '#tag' => 'p',
        '#value' => $this->t("%cid", ['%cid' => $cid]),
      );

      $vocabulaires = [];
      foreach ($code['vocabulaires'] as $vocabulaire) {
        $vocabulaires[] = array(
          "#type" => 'html_tag',
          '#tag' => 'p',
          '#value' => $this->t("%voc_name", ['%voc_name' => $vocabulaire['vocabulaire_name']]),
          '#attributes' => array('class' => array('liste-vocabulaires small-text')),
        );
      }
      $content['table'][$cid]['vocabulaires'] = $vocabulaires;

      $content['table'][$cid]['edit'] = [
        '#title' => $this->t('Edit'),
        '#type' => 'link',
        '#url' => Url::fromRoute('wikilex_codes.manage_code',['cid' => $cid]),
      ];
      $content['table'][$cid]['delete'] = [
        '#title' => $this->t('Delete'),
        '#type' => 'link',
        '#url' => Url::fromRoute('wikilex_codes.delete_form',['cid' => $cid]),
      ];

    }

    // Don't cache this page.
    $content['#cache']['max-age'] = 0;



    return $content;
  }


}
