<?php

namespace Drupal\outline\Ajax;

use Drupal\Core\Ajax\CommandInterface;
use Drupal\outline\EntryInterface;

/**
 * Defines an AJAX command that sets the toolbar subtrees.
 */
class renameEntryCommand implements CommandInterface {

  /**
   * The entry id.
   *
   * @var integer
   */
  protected $id;

  /**
   * The new name.
   *
   * @var integer
   */
  protected $name;

  /**
   * Constructs an renameEntryCommand object.
   *
   * @param integer $id
   *   The entity id.
   * @param integer $name
   *   The new name.
   */
  public function __construct($id, $name) {
    $this->id = $id;
    $this->name = trim($name);
  }

  /**
   * {@inheritdoc}
   */
  public function render() {

    /* @var $entry \Drupal\outline\EntryInterface */

    // Get the entry.
    $entry = \Drupal::entityTypeManager()
      ->getStorage('outline_entry')
      ->load($this->id);

    //$entry->set('name', $this->name);
    $entry->setName($this->name);
    $entry->save();

    // Return the markup. @Todo return success/failure status
    return [
      'command' => 'renameEntry',
      'renameEntry' => 'Placeholder',
    ];
  }
}
