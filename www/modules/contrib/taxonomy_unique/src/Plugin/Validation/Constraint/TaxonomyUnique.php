<?php

namespace Drupal\taxonomy_unique\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * Taxonomy unique constraint.
 *
 * @Constraint(
 *   id = "taxonomy_unique",
 *   label = @Translation("Taxonomy unique", context = "Validation")
 * )
 */
class TaxonomyUnique extends Constraint {

  public $notUnique = 'Term %term already exists in vocabulary %vocabulary.';

  /**
   * Overwrites the default error message.
   */
  public function setErrorMessage($message) {
    $this->notUnique = $message;
  }

}
