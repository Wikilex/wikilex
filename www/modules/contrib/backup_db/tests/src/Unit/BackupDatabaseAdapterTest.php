<?php

/**
 * @file
 * Contains \Drupal\Tests\backup_db\Unit\BackupDatabaseAdapterTest
 */

namespace Drupal\Tests\backup_db\Unit;

use Drupal\Tests\UnitTestCase;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\backup_db\Adapter\BackupDatabaseLocalAdapter;
use Drupal\backup_db\Adapter\BackupDatabaseRemoteAdapter;

/**
 * Test BackupDatabaseAdapterInterface
 *
 * @coversDefaultClass \Drupal\backup_db\Adapter\BackupDatabaseAdapterInterface
 * @group backup_db
 */
class BackupDatabaseAdapterTest extends UnitTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();

    $container = new ContainerBuilder();
    $client = $this->prophesize('Drupal\backup_db\BackupDatabaseClient');
    $container->set('backup_db.client', $client->reveal());
    \Drupal::setContainer($container);  
  }

  /**
   * @coversDefaultClass \Drupal\backup_db\Adapter\BackupDatabaseLocalAdapter
   */
  public function testLocalAdapter() {
    $client = \Drupal::service('backup_db.client');
    $this->assertInstanceOf('Drupal\backup_db\Adapter\BackupDatabaseAdapterInterface', new BackupDatabaseLocalAdapter($client));
  }

  /**
   * @coversDefaultClass \Drupal\backup_db\Adapter\BackupDatabaseRemoteAdapter
   */
  public function testRemoteAdapter() {
    $client = \Drupal::service('backup_db.client');
    $this->assertInstanceOf('Drupal\backup_db\Adapter\BackupDatabaseAdapterInterface', new BackupDatabaseRemoteAdapter($client)); 
  }

}
