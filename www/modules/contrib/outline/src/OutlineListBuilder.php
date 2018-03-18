<?php

namespace Drupal\outline;

use Drupal\Core\Config\Entity\DraggableListBuilder;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of outline entities.
 *
 * @see \Drupal\outline\Entity\Outline
 */
class OutlineListBuilder extends DraggableListBuilder {

  /**
   * {@inheritdoc}
   */
  protected $entitiesKey = 'outlines';

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'outline_overview';
  }

  /**
   * {@inheritdoc}
   */
  public function getDefaultOperations(EntityInterface $entity) {
    $operations = parent::getDefaultOperations($entity);

    $operations['view'] = [
      'title' => t('View outline'),
      'weight' => 0,
      'url' => $entity->urlInfo('canonical'),
    ];

    if (isset($operations['edit'])) {
      $operations['edit']['title'] = t('Edit outline');
      $operations['edit']['weight'] = 10;
    }

    // @todo why doesn't this work?
    //    $operations['edit'] = array(
    //      'title' => t('Edit outline'),
    //      'weight' => 0,
    //    );

    $operations['delete'] = [
      'title' => t('Delete outline'),
      'weight' => 20,
      'url' => $entity->urlInfo('delete-form'),
    ];

    $operations['add'] = [
      'title' => t('Add entries'),
      'weight' => 30,
      'url' => Url::fromRoute('entity.outline_entry.add_form', ['outline' => $entity->id()]),
    ];

    // @todo Why does taxonomoy module unset delete
    //unset($operations['delete']);

    return $operations;
  }

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['label'] = t('Outline name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {

    $url = Url::fromRoute('entity.outline.canonical',
      ['outline' => $entity->id()]);
    $link = \Drupal::l(t($entity->label()), $url);
    $row['label'] = $link;

    //    @todo should use toLink()
    //    $row['label'] = $entity->toLink($entity->label(), 'canonical', []);
    return $row + parent::buildRow($entity);
  }

  /**
   * {@inheritdoc}
   */
  public function render() {
    $entities = $this->load();

    // If there are not multiple outines, disable dragging by unsetting the weight key.
    if (count($entities) <= 1) {
      unset($this->weightKey);
    }

    $build = parent::render();
    $build['table']['#empty'] = t('No outlines available. <a href=":link">Add outline</a>.', [':link' => \Drupal::url('entity.outline.add_form')]);
    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildForm($form, $form_state);
    $form['outlines']['#attributes'] = ['id' => 'outline'];
    $form['actions']['submit']['#value'] = t('Save');

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    drupal_set_message(t('The configuration options have been saved.'));
  }

}
