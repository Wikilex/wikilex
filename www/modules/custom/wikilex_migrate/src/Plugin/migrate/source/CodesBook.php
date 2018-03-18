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
 *   id = "codes_book"
 * )
 */
class CodesBook extends SqlBase {

  // TODO : Gérer l'import d'un seul code, avec sélection sur le cID.
  /**
   * {@inheritdoc}
   */
  //public function __construct(array $configuration, $plugin_id, $plugin_definition, MigrationInterface $migration, StateInterface $state) {

    // Possiblement le moyen d'avoir une sélection dynamique de la table.
  //  parent::__construct($configuration, $plugin_id, $plugin_definition, $migration, $state);
 // }


 // protected function setUpDatabase(array $database_info) {
  //d($database_info);
 // }
  /**
   * {@inheritdoc}
   */
  public function query() {

    $query = $this->select('codes_versions', 'c')
      ->fields('c', array(
        'cID',
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
      'cid' => $this->t('CODE ID'),
    ];

    return $fields;
  }

  /**
   * {@inheritdoc}
   */
  public function getIds() {
    return [
      'cid' => [
        'type' => 'text',
        'alias' => 'cid',
      ],
    ];
  }

  public function prepareRow(Row $row) {
    return parent::prepareRow($row);
  }

}
