<?php

namespace Drupal\wikilex_migrate_tools\Commands;

use Drupal\migrate_tools\Commands\MigrateToolsCommands;
use Drupal\migrate_tools\MigrateExecutable;
use Drupal\migrate\Plugin\MigrationInterface;

/**
 * Drush commandes specialement conçues pour réaliser un import,
 * en passant une option supplémentaire.
 * Cette option permet de rechercher et d'importer par code de lois unique
 * plutot que d'essayer de tous les importer.
 * Nécessite Drush ^9.2
 */
class WikilexMigrateToolsCommands extends MigrateToolsCommands {

  /**
   * Perform one or more migration processes.
   *
   * @param string $migration_names
   *   ID of migration(s) to import. Delimit multiple using commas.
   * @param array $options
   *   Additional options for the command.
   *
   * @command migrate:import
   *
   * @option cid L'id du code de lois à importer
   * @option all Process all migrations.
   * @option group A comma-separated list of migration groups to import
   * @option tag Name of the migration tag to import
   * @option limit Limit on the number of items to process in each migration
   * @option feedback Frequency of progress messages, in items processed
   * @option idlist Comma-separated list of IDs to import
   * @option update  In addition to processing unprocessed items from the
   *   source, update previously-imported items with the current data
   * @option force Force an operation to run, even if all dependencies are not
   *   satisfied
   * @option execute-dependencies Execute all dependent migrations first.
   *
   * @usage migrate:import --all
   *   Perform all migrations
   * @usage migrate:import --group=beer
   *   Import all migrations in the beer group
   * @usage migrate:import --tag=user
   *   Import all migrations with the user tag
   * @usage migrate:import --group=beer --tag=user
   *   Import all migrations in the beer group and with the user tag
   * @usage migrate:import beer_term,beer_node
   *   Import new terms and nodes
   * @usage migrate:import beer_user --limit=2
   *   Import no more than 2 users
   * @usage migrate:import beer_user --idlist=5
   *   Import the user record with source ID 5
   *
   * @validate-module-enabled migrate_tools
   *
   * @aliases wmim, wikilex-migrate-import
   *
   * @throws \Exception
   *   If there are not enough parameters to the command.
   */
  public function wikilex_import(
    $migration_names = '',
    array $options = [
      'cid' => NULL,
      'all' => NULL,
      'group' => NULL,
      'tag' => NULL,
      'limit' => NULL,
      'feedback' => NULL,
      'idlist' => NULL,
      'update' => NULL,
      'force' => NULL,
      'execute-dependencies' => NULL,
    ]
  ) {
    $group_names = $options['group'];
    $tag_names = $options['tag'];
    $all = $options['all'];
    $additional_options = [];
    if (!$all && !$group_names && !$migration_names && !$tag_names) {
      throw new \Exception(dt('You must specify --all, --group, --tag or one or more migration names separated by commas'));
    }
    if (!$options['cid']) {
      throw new \Exception(dt("L'id du code de lois (CID) est obligatoire pour un import wikilex."));
    }

    foreach (['cid', 'limit', 'feedback', 'idlist', 'update', 'force'] as $option) {
      if ($options[$option]) {
        $additional_options[$option] = $options[$option];
      }
    }

    $migrations = $this->migrationsList($migration_names, $options);
    if (empty($migrations)) {
      $this->logger->error(dt('No migrations found.'));
    }

    // Take it one group at a time, importing the migrations within each group.
    foreach ($migrations as $group_id => $migration_list) {
      array_walk(
        $migration_list,
        [$this, 'executeMigration'],
        $additional_options
      );
    }
  }

  /**
   * Executes a single migration.
   *
   * If the --execute-dependencies option was given,
   * the migration's dependencies will also be executed first.
   *
   * @param \Drupal\migrate\Plugin\MigrationInterface $migration
   *   The migration to execute.
   * @param string $migration_id
   *   The migration ID (not used, just an artifact of array_walk()).
   * @param array $options
   *   Additional options of the command.
   *
   * @throws \Exception
   *   If some migrations failed during execution.
   */
  protected function executeMigration(
    MigrationInterface $migration,
    $migration_id,
    array $options = []
  ) {
    if (isset($options['execute-dependencies'])) {
      if ($required_IDS = $migration->get('requirements')) {
        $manager = $this->migrationPluginManager;
        $required_migrations = $manager->createInstances($required_IDS);
        $dependency_options = array_merge($options, ['is_dependency' => TRUE]);
        array_walk($required_migrations, __FUNCTION__, $dependency_options);
      }
    }
    if (!empty($options['force'])) {
      $migration->set('requirements', []);
    }
    if (!empty($options['update'])) {
      $migration->getIdMap()->prepareUpdate();
    }
    $plugin_source = $migration->getSourcePlugin();
    $plugin_source->setCid($options['cid']);
    $executable = new MigrateExecutable($migration, $this->getMigrateMessage(), $options);
    // drush_op() provides --simulate support.
    drush_op([$executable, 'import']);
    if ($count = $executable->getFailedCount()) {
      // Nudge Drush to use a non-zero exit code.
      throw new \Exception(
        dt(
          '!name Migration - !count failed.',
          ['!name' => $migration_id, '!count' => $count]
        )
      );
    }
  }

}
