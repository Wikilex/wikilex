<?php

/**
 * @file
 * Contains \Drupal\Tests\backup_db\Unit\BackupDatabaseClientTest
 */

namespace Drupal\Tests\backup_db\Unit;

use Prophecy\Argument;
use Drupal\Tests\UnitTestCase;
use Drupal\Core\DependencyInjection\ContainerBuilder;

/**
 * Test BackupDatabaseClient
 *
 * @coversDefaultClass \Drupal\backup_db\BackupDatabaseClient
 * @group backup_db
 */
class BackupDatabaseClientTest extends UnitTestCase {

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();

    $handler = $this->prophesize('Drupal\backup_db\BackupDatabaseFileHandler');
    $connection = $this->prophesize('Drupal\Core\Database\Connection');
    $config = $this->prophesize('Drupal\Core\Config\ConfigFactoryInterface');

    $this->stub = $this->getMockBuilder('Drupal\backup_db\BackupDatabaseClient')
      ->setConstructorArgs([
        $handler->reveal(),
        $connection->reveal(),
        $config->reveal()
      ])
      ->setMethods(null)
      ->getMock();
  }

  public function testFileHandler() {
    $this->assertInstanceOf('Drupal\backup_db\BackupDatabaseFileHandler', $this->stub->getFileHandler());
  }

}
