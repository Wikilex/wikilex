<?php

/**
 * @file
 * Contains \Drupal\backup_db\Adapter\BackupDatabaseRemoteAdapter
 */

namespace Drupal\backup_db\Adapter;

use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

use Drupal\backup_db\Adapter\BackupDatabaseAdapterInterface;
use Drupal\backup_db\BackupDatabaseClientInterface;

/**
 * BackupDatabaseRemoteAdapter class.
 */
class BackupDatabaseRemoteAdapter implements BackupDatabaseAdapterInterface {

  /**
   * @var \Drupal\backup_db\BackupDatabaseClientInterface
   */
  private $client;

  /**
   * @param $client \Drupal\backup_db\BackupDatabaseClientInterface
   */
  public function __construct(BackupDatabaseClientInterface $client) {
    $this->client = $client;
  }

  /**
   * Export method.
   */
  public function export() {
    $handler = $this->client->getFileHandler();
    $handler->setupFile($this->client->getSettings());

    // @todo, run file validation here.
    $file = $handler->getFile();

    $export = $this->client->dump();
    $export->start($file->getFileUri());

    $this->download($file->getFileUri(), [
      'name' => $file->getFileName(),
      'type' => $file->getFileType()
    ]);

    return TRUE;
  }

  /**
   * Expose the export for download.
   */
  private function download($path, $config) {
    $response = new BinaryFileResponse($path);
    $response->trustXSendfileTypeHeader();
    $response->headers->set('Content-Type', $config['type']);
    $response->setContentDisposition(
        ResponseHeaderBag::DISPOSITION_ATTACHMENT,
        $config['name']
    );

    $response->prepare(\Symfony\Component\HttpFoundation\Request::createFromGlobals());
    $response->send();
  }
}
