<?php

namespace Drupal\outline;

use Drupal\Core\Config\Entity\ConfigEntityInterface;

/**
 * Provides an interface defining an outline entity.
 */
interface OutlineInterface extends ConfigEntityInterface {

  /**
   * Returns the outline description.
   *
   * @return string
   *   The outline description.
   */
  public function getDescription();

  /**
   * Returns default method of rendering outline entries.
   *
   * @return string
   *   The render method.
   */
  public function getRender();

  /**
   * Sets the default method of rendering outline entries.
   *
   * @param string $render
   *   The render method.
   */
  public function setRender($render);

  /**
   * Returns render name.
   *
   * @return string
   *   The render name.
   */
  public function getRenderName();

  /**
   * Returns the number of tree levels to expand.
   *
   * @return integer
   *   The outline expansion depth.
   */
  public function getExpandLevels();

  /**
   * Sets the default tree expansion depth.
   *
   * @param integer $expand_levels
   *   The number of tree levels to expand.
   */
  public function setExpandLevels($expand_levels);

  /**
   * Hide name field.
   *
   * @return boolean
   *   True if the name field should be hidden.
   */
  public function getHideName();

  /**
   * Show or hide the name field.
   *
   * @param boolean $hideName
   *   True if the name field should be hidden.
   */
  public function setHideName($hideName);

  /**
   * Returns the root entry id.
   *
   * @return integer
   *   The root entry id.
   */
  public function getRootEntryId();

  /**
   * Sets the root entry id.
   *
   * @param integer $expand
   *   The root entry id.
   */
  public function setRootEntryId($expand);

  /**
   * Returns the root entry.
   *
   * @return \Drupal\outline\EntryInterface
   *   The root entry.
   */
  public function getRootEntry();

  /**
   * Returns the site entry id.
   *
   * @return integer
   *   The site entry id.
   */
  public function getSiteEntryId();

  /**
   * Sets the site entry id.
   *
   * @param integer $site_entry_id
   *   The site entry id.
   */
  public function setSiteEntryId($site_entry_id);

  /**
   * Returns the site entry.
   *
   * @return \Drupal\outline\EntryInterface
   *   The site entry.
   */
  public function getSiteEntry();
  
  /**
   * Hide site entry.
   *
   * @param boolean $hide_site
   *   Hide site entry.
   */
  public function setHideSiteEntry($hide_site);

  /**
   * Get hide site entry setting.
   *
   * @return boolean
   *   Hide site entry setting.
   */
  public function getHideSiteEntry();

  /**
   * Get the top level entries.
   *
   * @return array
   *   The top level entries.
   */
  public function getTopLevelEntries();

}