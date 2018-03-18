<?php

namespace Drupal\wikilex_migrate\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;
use Drupal\migrate\Row;
use Drupal\node\Entity\Node;

/**
 * Source plugin for Section content.
 *
 * @MigrateSource(
 *   id = "sections"
 * )
 */
class Sections extends SqlBase {

  // TODO : Gérer la sélection de la table, à partir du cID.
  /**
   * {@inheritdoc}
   */
  public function query() {
    $query = $this->select('C_06070666_sections', 's')
      ->fields('s', array(
        'id',
        'cid',
        'cid_full',
        'titre_ta',
        'parent',
        'mtime',
      ));
    return $query;
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    $fields = [
      'id' => $this->t('LEGI SECTION ID'),
      'cid' => $this->t('CODE ID'),
      'cid_full' => $this->t('LEGI CODE ID'),
      'titre_ta' => $this->t('Titre'),
      'parent' => $this->t('Section Parent'),
      'mtime' => $this->t('mtime Legi-php'),
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

  public function prepareRow(Row $row) {
    //drush_print_r($row);
    return parent::prepareRow($row);
  }

  public function preprare(Node $node) {
   // drush_print_r($node);
  }
}
