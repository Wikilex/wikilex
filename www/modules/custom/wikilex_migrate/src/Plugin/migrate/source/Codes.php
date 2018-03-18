<?php

namespace Drupal\wikilex_migrate\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;
use Drupal\migrate\Row;
use Drupal\migrate\Plugin\MigrationInterface;
use Drupal\Core\State\StateInterface;

/**
 * Source plugin for code_de_lois content.
 *
 * @MigrateSource(
 *   id = "codes"
 * )
 */
class Codes extends SqlBase {

  // TODO : Gérer l'import d'un seul code, avec sélection sur le cID.
  /**
   * {@inheritdoc}
   */
  //public function __construct(array $configuration, $plugin_id, $plugin_definition, MigrationInterface $migration, StateInterface $state) {

    // Possiblement le moyen d'avoir une sélection dynamique de la table.
  //  parent::__construct($configuration, $plugin_id, $plugin_definition, $migration, $state);
 // }


  /**
   * {@inheritdoc}
   */
  public function query() {
    $query = $this->select('codes_versions', 'c')
      ->fields('c', array(
        'cID',
        'cid_full',
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

    if (isset($this->configuration['cid'])) {
      $query->condition('c.cID', $this->configuration['cid']);
      //d($this->configuration);
      //drush_print_r($this->configuration);
    }
    return $query;
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    $fields = [
      'cID' => $this->t('CODE ID'),
      'cid_full' => $this->t('LEGI CODE ID'),
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
      'cID' => [
        'type' => 'text',
        'alias' => 'cID',
      ],
    ];
  }

  public function prepareRow(Row $row) {
   // drush_print_r($row);
    return parent::prepareRow($row);
  }

}
