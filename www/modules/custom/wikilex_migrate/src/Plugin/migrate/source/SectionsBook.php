<?php

namespace Drupal\wikilex_migrate\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;
use Drupal\migrate\Row;
use Drupal\node\Entity\Node;

/**
 * Source plugin for Section content.
 *
 * @MigrateSource(
 *   id = "sections_book"
 * )
 */
class SectionsBook extends SqlBase {

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
        'parent',
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
      'parent' => $this->t('Section Parent'),
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
    // @todo : PID = le nid du parent
    if (empty($parent = $row->getSourceProperty('parent'))) {
      $parent =  $row->getSourceProperty('cid');
    }
    else {
      $parent = $row->getSourceProperty('parent');
    }

    $row->setSourceProperty('parent', $parent);
    // @todo : weight = es ce qu'il ya  d'autres nodes au même niveau ?
    // @todo : has_children, es ce qu'il y a c'est le parent d'une autre section ?
    // @todo : p1, p2, p3 etc.
    // @todo : depth.

    return parent::prepareRow($row);
  }

/*  public function preprare(Node $node) {
   // drush_print_r($node);
  }*/
}
