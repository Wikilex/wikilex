<?php

namespace Drupal\outline;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;

/**
 * Provides an interface defining an outline entry entity.
 */
interface EntryInterface extends ContentEntityInterface, EntityChangedInterface {

  /**
   * Gets the name of the entry.
   *
   * @return string
   *   The name of the entry.
   */
  public function getName();

  /**
   * Sets the name of the entry.
   *
   * @param string $name
   *   The entry's name.
   *
   * @return $this
   */
  public function setName($name);

  /**
   * Gets the entry's content.
   *
   * @return string
   *   The entry's content.
   */
  public function getContent();

  /**
   * Sets the entry's content.
   *
   * @param string $content
   *   The entry's content.
   *
   * @return $this
   */
  public function setContent($description);

  /**
   * Gets the text format name for the entry's description.
   *
   * @return string
   *   The text format name.
   */
  public function getFormat();

  /**
   * Sets the text format name for the entry's description.
   *
   * @param string $format
   *   The entry's description text format.
   *
   * @return $this
   */
  public function setFormat($format);

  /**
   * Gets the weight of this entry.
   *
   * @return int
   *   The weight of the entry.
   */
  public function getWeight();

  /**
   * Gets the weight of this entry.
   *
   * @param int $weight
   *   The entry's weight.
   *
   * @return $this
   */
  public function setWeight($weight);

  /**
   * Gets the disabled state of this entry.
   *
   * @return int
   *   The disabled state of the entry.
   */
  public function getDisabled();

  /**
   * Gets the disabled state of this entry.
   *
   * @param int $disabled
   *   The entry's disabled state.
   *
   * @return $this
   */
  public function setDisabled($disabled);

  /**
   * Gets the expanded state of this entry.
   *
   * @return int
   *   The expanded state of the entry.
   */
  public function getExpanded();

  /**
   * Gets the expanded state of this entry.
   *
   * @param int $expanded
   *   The entry's expanded state.
   *
   * @return $this
   */
  public function setExpanded($expanded);

  /**
   * Get the outline id this entry belongs to.
   *
   * @return string
   *   The id of the outline.
   */
  public function getOutlineId();

  /**
   * Get the outline this entry belongs to.
   *
   * @return \Drupal\outline\Entity\Outline
   *   The outline.
   */
  public function getOutline();

  /**
   * Get the entity id of this entry.
   *
   * @return integer
   *   The entity id.
   */
  public function getCalcEntityId();

  /**
   * Get the entity type of this entry.
   *
   * @return string
   *   The entity type.
   */
  public function getCalcEntityType();

  /**
   * Get the entity mode of this entry.
   *
   * @return integer
   *   The entity mode.
   */
  public function getCalcEntityMode();

  /**
   * Get the display name of this entry.
   *
   * @return string
   *   The display name.
   */
  public function getCalcEntityDisplay();

  /**
   * Get the edit url name of this entry.
   *
   * @return string
   *   The edit url.
   */
  public function getCalcEntityEditUrl();

  /**
   * Get the entry type of this entry.
   *
   * @return string
   *   The entry type.
   */
  public function getCalcEntryType();

  /**
   * Is entry a root entry?
   *
   * @return boolean
   *   True if entry is a root entry.
   */
  public function isRoot();

  /**
   * Is entry a site entry?
   *
   * @return boolean
   *   True if entry is a site entry.
   */
  public function isSite();

  /**
   * Get this entry's children.
   *
   * @return array
   *   An array of children.
   */
  public function getChildren();

  /**
   * Get this entry's parent.
   *
   * @return \Drupal\outline\EntryInterface
   *   The parent entry.
   */
  public function getParent();

  /**
   * Get this entry's parent.
   *
   * @return \Drupal\outline\EntryInterface
   *   The parent entry.
   */
  public function getAllParents();


    /**
     * Is entry a site entry?
     *
     * @param \Zend\Feed\Reader\Entry\EntryInterface $entry
     *   The entry's name.
     *
     * @return boolean
     *   True if entry is in the parent hierarchy.
     */
    public function hasParent($entry);

}
