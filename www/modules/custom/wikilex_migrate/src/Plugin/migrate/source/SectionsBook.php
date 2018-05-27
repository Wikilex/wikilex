<?php

namespace Drupal\wikilex_migrate\Plugin\migrate\source;

use Drupal\book\BookManager;
use Drupal\book\BookOutlineStorage;
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
      $cid=  $row->getSourceProperty('cid');
     // $row->setSourceProperty('parent', $parent);
      var_dump('empty parent');
      dump($cid);
      $pid = $this->getPid('code_de_lois', 'field_cid', $cid);
      dump($pid);
    }
    else {
      var_dump('not empty parent');
      $parent = $row->getSourceProperty('parent');
      $pid = $this->getPid('section', 'field_cle_legi', $parent);
      dump($pid);

      // @todo : has_children, es ce que c'est le parent d'une autre section ?
    }
    if (!empty($pid)) {
      $row->setSourceProperty('pid', current($pid));
    }


    return parent::prepareRow($row);
  }

  protected function getPid($bundle, $field_name, $value) {
    $query = \Drupal::entityQuery('node')
      ->condition('type', $bundle)
      ->condition($field_name, $value);
    return $query->execute();
  }

/*  public function preprare(Node $node) {
   // drush_print_r($node);
  }*/
}
