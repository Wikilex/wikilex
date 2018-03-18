<?php

namespace Drupal\wikilex_migrate\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;
use Drupal\migrate\Row;

/**
 * Source plugin for Section content.
 *
 * @MigrateSource(
 *   id = "articles"
 * )
 */
class Articles extends SqlBase {

  // TODO : Gérer la sélection de la table, à partir du cID.
  /**
   * {@inheritdoc}
   */
  public function query() {
    $query = $this->select('C_06070666_articles', 'a')
      ->fields('a', array(
        'id',
        'cid',
        'cid_full',
        'parent',
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
    return $query;
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    $fields = [
      'id' => $this->t('LEGI ARTICLE ID'),
      'cid' => $this->t('CODE ID'),
      'cid_full' => $this->t('LEGI CODE ID'),
      'titre_ta' => $this->t('Titre'),
      'parent' => $this->t('Section Parent'),
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
    if ($value = $row->getSourceProperty('num')) {
      $row->setSourceProperty('title', 'Article ' . $value);
    }

    return parent::prepareRow($row);
  }

}
