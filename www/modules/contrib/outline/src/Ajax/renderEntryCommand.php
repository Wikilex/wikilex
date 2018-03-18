<?php

namespace Drupal\outline\Ajax;

use Drupal\Core\Ajax\CommandInterface;
use Drupal\outline\entity\Entry;

/**
 * Defines an AJAX command that renders outline entries.
 */
class renderEntryCommand implements CommandInterface {

  /**
   * The entity type.
   *
   * @var string
   */
  protected $type;

  /**
   * The entity id.
   *
   * @var integer
   */
  protected $id;

  /**
   * Render entity as "display" or "form".
   *
   * @var array
   */
  protected $render;

  /**
   * The mode to render.
   *
   * @var string
   */
  protected $mode;

  /**
   * Constructs a renderEntryCommand object.
   *
   * @param string $type
   *   The entity type.
   * @param integer $id
   *   The entity id.
   * @param integer $render
   *   How to render the entity, acceptable values are "display" or "form".
   * @param string $mode
   *   The entity render mode.
   *
   */
  public function __construct($type = 'outline_entry', $id, $render = Entry::RENDER_AS_DISPLAY, $mode = "full") {
    $this->type = (String) $type;
    $this->id = $id;
    $this->render = $render;
    $this->mode = $mode;
  }

  /**
   * {@inheritdoc}
   */
  public function render() {

    // Get the entity.
    $entity = \Drupal::entityTypeManager()
      ->getStorage($this->type)
      ->load($this->id);

    // Create render array.
    if ($this->render == Entry::RENDER_AS_DISPLAY) {
      $renderArray =
        \Drupal::entityTypeManager()
          ->getViewBuilder($this->type)
          ->view($entity, $this->mode);
    }
    elseif ($this->render == Entry::RENDER_AS_FORM) {

      // @Todo This also works, which approach is preferred?:
      //    renderArray =
      //      \Drupal::service('entity.form_builder')->getForm($entity);

      $form = \Drupal::service('entity.manager')
        ->getFormObject('outline_entry', 'default')
        ->setEntity($entity);
      $renderArray = \Drupal::formBuilder()->getForm($form);
    }

    // Return the markup.
    $markup = \Drupal::service('renderer')->render($renderArray);
    return [
      'command' => 'renderEntry',
      'renderedEntry' => $markup,
    ];
  }
}
