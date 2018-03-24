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
    $cid = 'C_06070666';
    if (isset($this->configuration['cid'])) {
      $cid = $this->configuration['cid'];
      //d($this->configuration);
      //drush_print_r($this->configuration);
    }
    $query = $this->select($cid . '_sections', 's')
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

  /**
   * {@inheritdoc}
   */
  public function prepareRow(Row $row) {
    // Preparation for the Title.
    $title = $row->getSourceProperty('titre_ta');
    if (strlen($title) > 254) {
      $title = substr($title,0, 254);
    }
    //$title = $title;
    //$row->setSourceProperty('title', 'data');
    $row->setSourceProperty('titre', $title);
    return parent::prepareRow($row);
  }

/*  public function preprare(Node $node) {
   // drush_print_r($node);
  }*/
}
