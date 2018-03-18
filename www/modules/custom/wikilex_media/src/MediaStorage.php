<?php

namespace Drupal\wikilex_media;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\ows_entity\Entity\ClassyBundleTrait;

/**
 * Sample Storage, providing guidance on how to use ClassyBundleTrait.
 *
 * Concrete usages will need to depend on the medias defined in the
 * website, so this needs to be changed.
 */
class MediaStorage extends SqlContentEntityStorage {

  use ClassyBundleTrait;

  const BUNDLE_CLASSES = [];

}
