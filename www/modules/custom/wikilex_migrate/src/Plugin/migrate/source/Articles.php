<?php

namespace Drupal\wikilex_migrate\Plugin\migrate\source;

use Drupal\migrate\Row;

/**
 * Source plugin for Section content.
 *
 * @MigrateSource(
 *   id = "articles"
 * )
 */
class Articles extends ImportWikilex {

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
    // Renseigne un cid par default afin de
    // pas provoquer de bug avec les commandes drush de migration ordinaires.
    if (empty($this->cid)) {
      $cid = 'C_06070666';
    }
    else {
      $cid = $this->cid;
    }

    $query = $this->select('articles', 'a')
      ->fields('a', array(
        'id',
        'cid',
        'sections',
        'bloc_textuel',
        'num',
        'etat',
        'date_debut',
        'date_fin',
        'type',
        'dossier',
        'nota',
        'mtime',
      ));
    $query->condition('a.cid', $this->codesListe->getCidTexte($cid));
    return $query;
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    $fields = [
      'id' => $this->t('LEGI ARTICLE ID'),
      'cid' => $this->t('LEGI CODE ID'),
      'sections' => $this->t('Section Parent'),
      'bloc_textuel' => $this->t('Bloc Textuel'),
      'num' => $this->t('Num'),
      'etat' => $this->t('Etat'),
      'date_debut' => $this->t('Date début'),
      'date_fin' => $this->t('Date fin'),
      'type' => $this->t('Type'),
      'dossier' => $this->t('Dossier'),
      'nota' => $this->t('Nota'),
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
    $title = $row->getSourceProperty('id');
    if ($num= $row->getSourceProperty('num')) {
      $title = $num;
    }
    $row->setSourceProperty('title', 'Article ' . $title);

    // Preparation pour le status de publication
    $status = 1;
    if ($etat = $row->getSourceProperty('etat')) {
      if ($etat == 'ABROGE' || $etat == 'MODIFIE_MORT_NE') {
        $status = 0;
      }
    }
    if ($date_fin = $row->getSourceProperty('date_fin')) {
      $dateTime = date_create_from_format('Y-m-d', $date_fin);
      if($dateTime < new \DateTime('NOW')) {
        $status = 0;
      }
    }
    $row->setSourceProperty('status', $status);

    return parent::prepareRow($row);
  }

}
