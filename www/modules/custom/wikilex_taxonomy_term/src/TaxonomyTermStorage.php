<?php

namespace Drupal\wikilex_taxonomy_term;

use Drupal\ows_entity\Entity\ClassyBundleTrait;
use Drupal\taxonomy\TermStorage as CoreStorage;

/**
 * Sample Storage, providing guidance on how to use ClassyBundleTrait.
 *
 * Concrete usages will need to depend on the taxonomy terms defined in the
 * website, so this needs to be changed.
 */
class TaxonomyTermStorage extends CoreStorage {

  use ClassyBundleTrait;

  const BUNDLE_CLASSES = [];

}
