<?php

namespace Drupal\Tests\taxonomy_unique\Kernel;

use Drupal\KernelTests\KernelTestBase;
use Drupal\Tests\taxonomy\Functional\TaxonomyTestTrait;

/**
 * Tests for taxonomy unique module.
 *
 * @group taxonomy_unique
 */
class TaxonomyUniqueTest extends KernelTestBase {
  use TaxonomyTestTrait;

  public static $modules = [
    'taxonomy',
    'taxonomy_unique',
    'text',
    'filter',
    'user',
  ];

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();
    $this->installConfig(['filter']);
    $this->installEntitySchema('taxonomy_term');
  }

  /**
   * Tests the basic functionality with taxonomy_unique turned on in the vocabulary settings.
   */
  public function testDuplicateTermWithTuEnabled() {
    $vocabulary = $this->createVocabulary();
    $GLOBALS['config']['taxonomy_unique.settings'] = [$vocabulary->id() => TRUE];

    $t1 = $this->createTerm($vocabulary, ['name' => 'Term 1']);
    $t1_violations = $t1->validate();
    $this->assertEquals(0, $t1_violations->count());

    $t2 = $this->createTerm($vocabulary, ['name' => 'Term 1']);
    $t2_violations = $t2->validate();
    $this->assertEquals(1, $t2_violations->count());

    $t3 = $this->createTerm($vocabulary, ['name' => 'Term 2']);
    $t3_violations = $t3->validate();
    $this->assertEquals(0, $t3_violations->count());
  }

  /**
   * Tests the basic functionality with taxonomy_unique turned off in the vocabulary settings.
   */
  public function testDuplicateTermWithTuDisabled() {
    $vocabulary = $this->createVocabulary();

    $t1 = $this->createTerm($vocabulary, ['name' => 'Term 1']);
    $t1_violations = $t1->validate();
    $this->assertEquals(0, $t1_violations->count());

    $t2 = $this->createTerm($vocabulary, ['name' => 'Term 1']);
    $t2_violations = $t2->validate();
    $this->assertEquals(0, $t2_violations->count());
  }

  /**
   * Tests whether terms with the same name can be saved in different vocabularies.
   */
  public function testCrossVocabulary() {
    $vocabulary1 = $this->createVocabulary();
    $vocabulary2 = $this->createVocabulary();

    $GLOBALS['config']['taxonomy_unique.settings'] = [$vocabulary1->id() => TRUE, $vocabulary2->id() => TRUE];

    $t1 = $this->createTerm($vocabulary1, ['name' => 'Term 1']);
    $t1_violations = $t1->validate();
    $this->assertEquals(0, $t1_violations->count());

    $t2 = $this->createTerm($vocabulary2, ['name' => 'Term 1']);
    $t2_violations = $t2->validate();
    $this->assertEquals(0, $t2_violations->count());
  }

  /**
   * Tests whether terms can be saved using another terms name.
   */
  public function testEditTerm() {
    $vocabulary = $this->createVocabulary();
    $GLOBALS['config']['taxonomy_unique.settings'] = [$vocabulary->id() => TRUE];

    $t1 = $this->createTerm($vocabulary, ['name' => 'Term 1']);
    $t1_violations = $t1->validate();
    $this->assertEquals(0, $t1_violations->count());

    $t2 = $this->createTerm($vocabulary, ['name' => 'Term 2']);
    $t2_violations = $t2->validate();
    $this->assertEquals(0, $t2_violations->count());

    $t2->setName('Term 1');
    $t2->save();
    $violations = $t2->validate();
    $this->assertEquals(1, $violations->count());
  }

}
