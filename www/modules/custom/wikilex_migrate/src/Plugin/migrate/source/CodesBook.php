<?php

namespace Drupal\wikilex_migrate\Plugin\migrate\source;

/**
 * Source plugin for code_de_lois content.
 *
 * @MigrateSource(
 *   id = "codes_book"
 * )
 */
class CodesBook extends ImportWikilex {

  /**
   * L'id unique du code de lois à importer
   *
   * @var string
   */
  protected $cid;

  /**
   * Fonction pour définir le CID.
   *
   * Utilisation prévue avec WikilexMigrateToolsCommands::wikilex_import(),
   * et avec un cid valide passé en option de la commande.
   *
   * @param string $cid
   */
  public function setCid($cid) {
    $this->cid = $cid;
  }

  /**
   * {@inheritdoc}
   */
  public function query() {

    // Renseigne un cid par default afin de
    // pas provoquer de bug avec les commandes drush de migration ordinaires.
    if (empty($this->cid)) {
      $cid = 'C_06070666';
    }
    else {
      $cid = $this->cid;
    }


    $query = $this->select('textes_versions', 'tv')
      ->fields('tv', array(
        'id',
      ));

    $query->condition('tv.id', $this->codesListe->getCidTexte($cid));

    return $query;
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    $fields = [
      'id' => $this->t('CODE ID'),
    ];

    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function getIds() {
    return [
      'id' => [
        'type' => 'text',
        'alias' => 'id',
      ],
    ];
  }

}
