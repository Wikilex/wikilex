<?php

namespace Drupal\wikilex_taxonomy_term\Entity;

use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\taxonomy\Entity\Term;

/**
 * Base for all taxonomy term.
 */
class BaseTaxonomyTerm extends Term {

  use StringTranslationTrait;

}
