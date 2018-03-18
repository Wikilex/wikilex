<?php

namespace Drupal\wikilex_node;

use Drupal\node\NodeStorage as CoreStorage;
use Drupal\ows_entity\Entity\ClassyBundleTrait;

/**
 * Sample Storage, providing guidance on how to use ClassyBundleTrait.
 *
 * Concrete usages will need to depend on the content types defined in the
 * website, so this needs to be changed.
 */
class NodeStorage extends CoreStorage {

  use ClassyBundleTrait;

  const BUNDLE_CLASSES = [];

}
