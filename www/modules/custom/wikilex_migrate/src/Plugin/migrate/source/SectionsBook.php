<?php

namespace Drupal\wikilex_migrate\Plugin\migrate\source;

use Drupal\migrate\Row;

/**
 * Source plugin for Section content.
 *
 * @MigrateSource(
 *   id = "sections_book"
 * )
 */
class SectionsBook extends ImportWikilex {

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

    $query = $this->select('sections', 's')
      ->fields('s', array(
        'id',
        'cid',
        'parent',
      ));
    $query->condition('s.cid', $this->codesListe->getCidTexte($cid));
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

    if (empty($parent = $row->getSourceProperty('parent'))) {
      $cid=  $row->getSourceProperty('cid');
      $pid = $this->getPid('code_de_lois', 'field_cid', $cid);
    }
    else {
      $parent = $row->getSourceProperty('parent');
      $pid = $this->getPid('section', 'field_cle_legi', $parent);

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

}
