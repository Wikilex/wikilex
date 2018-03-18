<?php

namespace Drupal\outline;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Defines the access control handler for the outline entry entity type.
 *
 * @see \Drupal\outline\Entity\Entry
 */
class EntryAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    switch ($operation) {
      case 'view':
        return AccessResult::allowedIfHasPermission($account, 'access content');
        break;

      case 'update':
        return AccessResult::allowedIfHasPermissions($account, ["edit entries in {$entity->bundle()}", 'administer outlines'], 'OR');
        break;

      case 'delete':
        return AccessResult::allowedIfHasPermissions($account, ["delete entries in {$entity->bundle()}", 'administer outlines'], 'OR');
        break;

      default:
        // No opinion.
        return AccessResult::neutral();
    }
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'administer outlines');
  }

}
