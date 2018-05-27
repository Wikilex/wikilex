<?php

namespace Drupal\wikilex_migrate\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;
use Drupal\migrate\Row;

/**
 * Source plugin for Section content.
 *
 * @MigrateSource(
 *   id = "sections"
 * )
 */
class Sections extends SqlBase {

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
    $cid = $this->cid;
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

}
