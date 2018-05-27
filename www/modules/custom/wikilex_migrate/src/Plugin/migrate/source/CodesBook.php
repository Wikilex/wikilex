<?php

namespace Drupal\wikilex_migrate\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;
use Drupal\migrate\Row;

/**
 * Source plugin for code_de_lois content.
 *
 * @MigrateSource(
 *   id = "codes_book"
 * )
 */
class CodesBook extends SqlBase {

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

    if (empty($this->cid)) {
      return [];
    }

    $query = $this->select('codes_versions', 'c')
      ->fields('c', array(
        'cID',
      ));

    $query->condition('c.cID', $this->cid);

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
