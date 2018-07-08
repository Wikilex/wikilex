<?php

namespace Drupal\wikilex_migrate\Plugin\migrate\source;

use Drupal\migrate\Row;

/**
 * Source plugin for Section content.
 *
 * @MigrateSource(
 *   id = "sections"
 * )
 */
class Sections extends ImportWikilex {

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
        'titre_ta',
        'commentaire',
        'parent',
        'mtime',
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
      'cid' => $this->t('LEGI CODE ID'),
      'titre_ta' => $this->t('Titre'),
      'parent' => $this->t('Section Parent'),
      'mtime' => $this->t('mtime Legi-php'),
      'commentaire' => $this->t('Commentaire'),
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
    $row->setSourceProperty('titre', $title);

    return parent::prepareRow($row);
  }



}
