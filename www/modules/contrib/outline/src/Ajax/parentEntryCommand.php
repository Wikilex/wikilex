<?php

namespace Drupal\outline\Ajax;

use Drupal\Core\Ajax\CommandInterface;
use Drupal\outline\EntryInterface;

/**
 * Defines an AJAX command that sets the toolbar subtrees.
 */
class parentEntryCommand implements CommandInterface {

  /**
   * The entry id.
   *
   * @var integer
   */
  protected $id;

  /**
   * The parent entry id.
   *
   * @var integer
   */
  protected $parent_id;

  /**
   * Constructs an parentEntryCommand object.
   *
   * @param integer $id
   *   The entity id.
   * @param integer $parent_id
   *   The entity parent_id.
   */
  public function __construct($id, $parent_id) {
    $this->id = intval($id);
    $this->parent_id = intval($parent_id);
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

    // Update Parent ID
    if ($this->parent_id == 0) {
      $entry->set('parent', ['target_id' => 0]);
    }
    else {
      // Set and save new parent ID.
      $entry->set('parent', ['target_id' => $this->parent_id]);
    }
    $entry->save();

    // Return the markup. @Todo return success/failure status
    return [
      'command' => 'parentEntry',
      'entryParent' => 'Placeholder',
    ];
  }
}
