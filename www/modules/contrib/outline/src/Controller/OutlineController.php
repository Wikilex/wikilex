<?php

namespace Drupal\outline\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\outline\Ajax\renderEntryCommand;
use Drupal\outline\Ajax\parentEntryCommand;
use Drupal\outline\Ajax\renameEntryCommand;
use Drupal\outline\Ajax\deleteEntryCommand;
use Drupal\outline\OutlineInterface;
use Drupal\outline\EntryInterface;
use Drupal\Core\Ajax\AjaxResponse;

/**
 * Provides route responses for outline.module.
 */
class OutlineController extends ControllerBase {

  /**
   * Returns a form to add a new entry to an outline.
   *
   * @param \Drupal\outline\OutlineInterface $outline
   *          The outline this entry will be added to.
   *
   * @return array The entry add form.
   */
  public function addForm(OutlineInterface $outline) {
    $storage = static::entityTypeManager()->getStorage('outline_entry');
    $entry = $storage->create([
      'oid' => $outline->id(),
      'parent' => $outline->getRootEntryId(),
    ]);
    return $this->entityFormBuilder()->getForm($entry);
  }

  /**
   * Route outline title callback.
   *
   * @param \Drupal\outline\OutlineInterface $outline
   *          The outline.
   *
   * @return string The outline label as a render array.
   */
  public function outlineTitle(OutlineInterface $outline) {
    return [
      '#markup' => $outline->label(),
      '#allowed_tags' => Xss::getHtmlTagList(),
    ];
  }

  /**
   * Route entry title callback.
   *
   * @param \Drupal\outline\EntryInterface $entry
   *          The outline entry.
   *
   * @return array The entry label as a render array.
   */
  public function entryTitle(EntryInterface $entry = NULL) {
    return [
//      '#markup' => $entry->getName(),
      '#markup' => 'temp',
      '#allowed_tags' => Xss::getHtmlTagList(),
    ];
  }

  /**
   * Render outline
   */
  public function outline(OutlineInterface $outline) {
    $build = [
      '#theme' => 'outline',
      '#outline' => $outline,
    ];
    return $build;
  }

  /**
   * Renders the React outline.
   *
   * @return array
   *   The render array.
   */
  public function outlineReact(OutlineInterface $outline) {
    $build = [];
    $build['#attached']['library'][] = 'outline/drupal.outline.react';
    $build['#markup'] = '<div id="root" />';
    return $build;
  }

  /**
   * Ajax callback to render entity in specified display mode.
   *
   * @param string $type
   *   The entity type.
   * @param integer $id
   *   The entity id.
   * @param string $render
   *   How to render the entity, acceptable values are "display" or "form".
   * @param string $mode
   *   The entity render mode.
   *
   * @return object $response
   *   The ajax response.
   *
   */
  public function renderEntry($type, $id, $render, $mode) {
    // Create AJAX Response object.
    $response = new AjaxResponse();
    $response->addCommand(new renderEntryCommand($type, $id, $render, $mode));
    return $response;
  }

  /**
   * Ajax callback to set an entry's parent.
   *
   * @param integer $id
   *   The entry id.
   * @param integer $parent_id
   *   The entry's parent_id.
   *
   * @return object $response
   *   The ajax response.
   */
  public function parentEntry($id, $parent_id) {
    // Create AJAX Response object.
    $response = new AjaxResponse();
    $response->addCommand(new parentEntryCommand($id, $parent_id));
    return $response;
  }

  /**
   * Ajax callback to rename an entry.
   *
   * @param integer $id
   *   The entry id.
   * @param integer $name
   *   The entry's new name.
   *
   * @return object $response
   *   The ajax response.
   */
  public function renameEntry($id, $name) {
    // Create AJAX Response object.
    $response = new AjaxResponse();
    $response->addCommand(new renameEntryCommand($id, $name));
    return $response;
  }

  /**
   * Ajax callback to delete an entry.
   *
   * @param integer $id
   *   The entry id.
   *
   * @return object $response
   *   The ajax response.
   */
  public function deleteEntry($id) {
    // Create AJAX Response object.
    $response = new AjaxResponse();
    $response->addCommand(new deleteEntryCommand($id));
    return $response;
  }

}
