<?php

namespace Drupal\outline;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Entity\EntityManagerInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides dynamic permissions of the outline module.
 *
 * @see outline.permissions.yml
 */
class OutlinePermissions implements ContainerInjectionInterface {

  use StringTranslationTrait;

  /**
   * The entity manager.
   *
   * @var \Drupal\Core\Entity\EntityManagerInterface
   */
  protected $entityManager;

  /**
   * Constructs an OutlinePermissions instance.
   *
   * @param \Drupal\Core\Entity\EntityManagerInterface $entity_manager
   *   The entity manager.
   */
  public function __construct(EntityManagerInterface $entity_manager) {
    $this->entityManager = $entity_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static($container->get('entity.manager'));
  }

  /**
   * Get outline permissions.
   *
   * @return array
   *   Permissions array.
   */
  public function permissions() {
    $permissions = [];
    foreach ($this->entityManager->getStorage('outline')->loadMultiple() as $outline) {
      $permissions += [
        'edit entries in ' . $outline->id() => [
          'title' => $this->t('Edit entries in %outline', ['%outline' => $outline->label()]),
        ],
      ];
      $permissions += [
        'delete entries in ' . $outline->id() => [
          'title' => $this->t('Delete entries from %outline', ['%outline' => $outline->label()]),
        ],
      ];
    }
    return $permissions;
  }

}
