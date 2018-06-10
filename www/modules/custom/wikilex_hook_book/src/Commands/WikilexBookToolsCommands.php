<?php

namespace Drupal\wikilex_hook_book\Commands;

use Drupal\wikilex_hook_book\CleanOutlines;
use Drush\Commands\DrushCommands;

/**
 * Drush commandes specialement conçues pour la gestion
 * de l'arborescende des books dans le projet Wikilex.
 */
class WikilexBookToolsCommands extends DrushCommands {

  /**
   * CleanOutlines service.
   *
   * @var \Drupal\wikilex_hook_book\CleanOutlines
   */
  protected $cleanOutlinesService;
  /**
   * MigrateToolsCommands constructor.
   *
   * @param \Drupal\wikilex_hook_book\CleanOutlines $cleanOutlines
   *   Migration Plugin Manager service.
   */
  public function __construct(
    CleanOutlines $cleanOutlines
  ) {
    parent::__construct();
    $this->cleanOutlinesService = $cleanOutlines;
  }

  /**
   * Commande pour netoyer l'arborescende d'un code de loi.
   *
   * @param int $bid
   *   Le nid du book.
   *
   * @command migrate:import
   *
   * @option bid Le nid du code de lois
   *
   * @validate-module-enabled wikilex_hook_book
   *
   * @aliases wcbo, wikilex-clean-book-outlines
   *
   * @throws \Exception
   *   If there are not enough parameters to the command.
   */
  public function commandCleanBookOutlines($bid) {
    $this->cleanOutlinesService->cleanBookOutline($bid);
  }

}
