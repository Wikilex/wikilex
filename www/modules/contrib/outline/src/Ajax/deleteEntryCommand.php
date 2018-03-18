<?php

namespace Drupal\outline\Ajax;

use Drupal\Core\Ajax\CommandInterface;
use Drupal\outline\EntryInterface;

/**
 * Defines an AJAX command that sets the toolbar subtrees.
 */
class deleteEntryCommand implements CommandInterface {

  /**
   * The entry id.
   *
   * @var integer
   */
  protected $id;

  /**
   * Constructs an deleteEntryCommand object.
   *
   * @param integer $id
   *   The entity id.
   */
  public function __construct($id) {
    $this->id = $id;
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
    $entry->delete();
    $entry->save();

    // Return the markup. @Todo return success/failure status
    return [
      'command' => 'deleteEntry',
      'deleteEntry' => 'Placeholder',
    ];
  }
}
