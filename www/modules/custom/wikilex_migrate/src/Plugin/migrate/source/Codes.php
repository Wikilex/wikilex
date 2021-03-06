<?php

namespace Drupal\wikilex_migrate\Plugin\migrate\source;

/**
 * Source plugin for code_de_lois content.
 *
 * @MigrateSource(
 *   id = "codes"
 * )
 */
class Codes extends ImportWikilex {

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
        'titrefull',
        'titrefull_s',
        'date_debut',
        'date_fin',
        'etat',
        'nature',
        'autorite',
        'ministere',
        'num',
        'num_sequence',
        'nor',
        'date_publi',
        'date_texte',
        'derniere_modification',
        'origine_publi',
        'page_deb_publi',
        'page_fin_publi',
        'visas',
        'signataires',
        'tp',
        'nota',
        'abro',
        'rect',
        'dossier',
        'mtime',
        'texte_id',
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
      'titrefull' => $this->t('Titre'),
      'titrefull_s' => $this->t('Titre full_s'),
      'date_debut' => $this->t('Date début'),
      'date_fin' => $this->t('Date fin'),
      'etat' => $this->t('Etat'),
      'nature' => $this->t('Nature'),
      'autorite' => $this->t('Autorité'),
      'ministere' => $this->t('Ministère'),
      'num' => $this->t('Num'),
      'num_sequence' => $this->t('Num Séquence'),
      'nor' => $this->t('NOR'),
      'date_publi' => $this->t('Date de publication'),
      'date_texte' => $this->t('Date Texte'),
      'derniere_modification' => $this->t('Dernière Modification'),
      'origine_publi' => $this->t('Origine publication'),
      'page_deb_publi' => $this->t('Page début publication'),
      'page_fin_publi' => $this->t('Page fin publication'),
      'visas' => $this->t('Visas'),
      'signataires' => $this->t('Signataires'),
      'tp' => $this->t('tp'),
      'nota' => $this->t('nota'),
      'abro' => $this->t('abro'),
      'rect' => $this->t('rect'),
      'dossier' => $this->t('dossier'),
      'mtime' => $this->t('mtime Legi-php'),
      'texte_id' => $this->t('texte_id'),
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
