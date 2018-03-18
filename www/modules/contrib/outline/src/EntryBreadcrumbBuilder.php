<?php

namespace Drupal\outline;

use Drupal\Core\Breadcrumb\BreadcrumbBuilderInterface;
use Drupal\Core\Breadcrumb\Breadcrumb;
use Drupal\Core\Entity\EntityManagerInterface;
use Drupal\Core\Link;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Provides a custom outline breadcrumb builder that uses the entry hierarchy.
 */
class EntryBreadcrumbBuilder implements BreadcrumbBuilderInterface {
  use StringTranslationTrait;

  /**
   * The entity manager.
   *
   * @var \Drupal\Core\Entity\EntityManagerInterface
   */
  protected $entityManager;

  /**
   * The outline entry storage.
   *
   * @var \Drupal\outline\EntryStorageInterface
   */
  protected $entryStorage;

  /**
   * Constructs the EntryBreadcrumbBuilder.
   *
   * @param \Drupal\Core\Entity\EntityManagerInterface $entityManager
   *   The entity manager.
   */
  public function __construct(EntityManagerInterface $entityManager) {
    $this->entityManager = $entityManager;
    $this->entryStorage = $entityManager->getStorage('outline_entry');
  }

  /**
   * {@inheritdoc}
   */
  public function applies(RouteMatchInterface $route_match) {
//    return $route_match->getRouteName() == 'entity.outline_entry.canonical'
//      && $route_match->getParameter('outline_entry') instanceof EntryInterface;
return TRUE;
  }

  /**
   * {@inheritdoc}
   */
  public function build(RouteMatchInterface $route_match) {
    $breadcrumb = new Breadcrumb();
    $breadcrumb->addLink(Link::createFromRoute($this->t('Home'), '<front>'));
    $entry = $route_match->getParameter('outline_entry');
    // Breadcrumb needs to have entries cacheable metadata as a cacheable
    // dependency even though it is not shown in the breadcrumb because e.g. its
    // parent might have changed.
    $breadcrumb->addCacheableDependency($entry);
    // @todo This overrides any other possible breadcrumb and is a pure
    //   hard-coded presumption. Make this behavior configurable per
    //   outline or entry.
    //$parents = $this->entryStorage->loadAllParents($entry->id());
    $parents = [];
    // Remove current entry being accessed.
    array_shift($parents);
    foreach (array_reverse($parents) as $entry) {
      $entry = $this->entityManager->getTranslationFromContext($entry);
      $breadcrumb->addCacheableDependency($entry);
      $breadcrumb->addLink(Link::createFromRoute($entry->getName(), 'entity.outline_entry.canonical', array('outline_entry' => $entry->id())));
    }

    // This breadcrumb builder is based on a route parameter, and hence it
    // depends on the 'route' cache context.
    $breadcrumb->addCacheContexts(['route']);

    return $breadcrumb;
  }

}
