<?php

/**
 * @file
 * Contains \Drupal\backup_db\Controller\BackupDatabaseController.
 */

namespace Drupal\backup_db\Controller;

use Drupal\Core\Url;
use Drupal\Core\Controller\ControllerBase;

/**
 * Display database backup history.
 */
class BackupDatabaseController extends ControllerBase {

  /**
   * {@inheritdoc}
   */
  public function historyOverview() {
    $query = db_select('backup_db', 'e');
    $count_query = clone $query;
    $count_query->addExpression('Count(e.eid)');

    $paged_query = $query->extend('Drupal\Core\Database\Query\PagerSelectExtender');
    // @todo, limit should be managed.
    $paged_query->limit(10);
    $paged_query->setCountQuery($count_query);

    $results = $paged_query
      ->fields('e', array('fid', 'name', 'uri', 'created'))
      ->orderBy('created', 'DESC')
      ->execute()
      ->fetchAll();

    $rows = array();
    foreach ($results as $result) {
      $url = backup_db_link($result->uri);
      $location = \Drupal::l($result->uri, Url::fromUri('base:/'.file_create_url($url)));
      $created = \Drupal::service('date.formatter')->format($result->created, 'html_date');

      $rows[$result->fid] = array(
        'fid' => $result->fid,
        'name' => $result->name,
        'location' => $location,
        'created' => $created
      );
    }

    // Return export history form.
    $form = \Drupal::formBuilder()->getForm('Drupal\backup_db\Form\BackupDatabaseHistoryForm', $rows);

    return array(
      'form' => $form,
      'pager' => array(
        '#type' => 'pager',
        '#weight' => 5,
      )
    );
  }
}
