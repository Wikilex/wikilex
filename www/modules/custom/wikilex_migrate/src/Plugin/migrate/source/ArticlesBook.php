<?php

namespace Drupal\wikilex_migrate\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;
use Drupal\migrate\Row;
use Drupal\node\Entity\Node;

/**
 * Source plugin for Article content.
 *
 * @MigrateSource(
 *   id = "articles_book"
 * )
 */
class ArticlesBook extends SqlBase {

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
    // Renseigne un cid par default.
    if (empty($this->cid)) {
      $cid = 'C_06070666';
    }
    else {
      $cid = $this->cid;
    }
    $query = $this->select($cid . '_articles', 'a')
      ->fields('a', array(
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

    // On n'ajoute pas à l'arborescence des articles non publiés.
      $status = $this->isPublished($row->getSourceProperty('id'));
       if (!$status) {
         return FALSE;
       }

    if (empty($parent = $row->getSourceProperty('parent'))) {
      $cid=  $row->getSourceProperty('cid');
      $pid = $this->getPid('code_de_lois', 'field_cid', $cid);
    }
    else {
      $parent = $row->getSourceProperty('parent');
      $pid = $this->getPid('section', 'field_cle_legi', $parent);
    }
    if (!empty($pid)) {
      $row->setSourceProperty('pid', current($pid));
    }


    return parent::prepareRow($row);
  }

  /**
   * @param $id
   *
   * @return array|int
   */
  protected function isPublished($id) {
    $query = \Drupal::entityQuery('node')
      ->condition('type', 'article_de_lois')
      ->condition('field_cle_legi', $id);
    $result = $query->execute();
    if (empty($result)) {
      return NULL;
    }
    /** @var \Drupal\node\Entity\Node $article */
    $article = Node::load(current($result));
    return $article->isPublished();
  }

  /**
   * Fonction pour trouver le nid du parent dans l'arborescence.
   * @param $bundle
   * @param $field_name
   * @param $value
   *
   * @return array|int
   */
  protected function getPid($bundle, $field_name, $value) {
    $query = \Drupal::entityQuery('node')
      ->condition('type', $bundle)
      ->condition($field_name, $value);
    return $query->execute();
  }

}
