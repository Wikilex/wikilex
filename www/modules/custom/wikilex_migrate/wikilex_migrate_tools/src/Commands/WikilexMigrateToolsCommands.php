<?php

namespace Drupal\wikilex_migrate_tools\Commands;

use Consolidation\OutputFormatters\StructuredData\RowsOfFields;
use Drupal\bootstrap\Utility\Unicode;
use Drupal\Core\Datetime\DateFormatter;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\migrate\Exception\RequirementsException;
use Drupal\migrate\Plugin\RequirementsInterface;
use Drupal\migrate_tools\Commands\MigrateToolsCommands;
use Drupal\migrate_tools\MigrateExecutable;
use Drupal\migrate\Plugin\MigrationInterface;

/**
 * Drush commandes specialement conçues pour réaliser un import,
 * ou obtenir un status de migration en passant une option supplémentaire.
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

  /**
   * List all migrations with current status.
   *
   * @param string $migration_names
   *   Restrict to a comma-separated list of migrations (Optional).
   * @param array $options
   *   Additional options for the command.
   *
   * @command migrate:status
   *
   * @option cid L'id du code de lois à importer
   * @option group A comma-separated list of migration groups to list
   * @option tag Name of the migration tag to list
   * @option names-only Only return names, not all the details (faster)
   *
   * @usage migrate:status
   *   Retrieve status for all migrations
   * @usage migrate:status --group=beer
   *   Retrieve status for all migrations in a given group
   * @usage migrate:status --tag=user
   *   Retrieve status for all migrations with a given tag
   * @usage migrate:status --group=beer --tag=user
   *   Retrieve status for all migrations in the beer group
   *   and with the user tag.
   * @usage migrate:status beer_term,beer_node
   *   Retrieve status for specific migrations
   *
   * @validate-module-enabled migrate_tools
   *
   * @aliases wms, wikilex-migrate-status
   *
   * @field-labels
   *   group: Group
   *   id: Migration ID
   *   status: Status
   *   total: Total
   *   imported: Imported
   *   unprocessed: Unprocessed
   *   last_imported: Last Imported
   * @default-fields group,id,status,total,imported,unprocessed,last_imported
   *
   * @return \Consolidation\OutputFormatters\StructuredData\RowsOfFields
   *   Migrations status formatted as table.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   */
  public function status(
    $migration_names = '',
    array $options = [
      'cid' => NULL,
      'group' => NULL,
      'tag' => NULL,
      'names-only' => NULL,
    ]
  ) {
    if (!$options['cid']) {
      throw new \Exception(dt("L'id du code de lois (CID) est obligatoire pour un status de migration wikilex."));
    }

    $names_only = $options['names-only'];

    $migrations = $this->migrationsList($migration_names, $options);

    $table = [];
    // Take it one group at a time, listing the migrations within each group.
    foreach ($migrations as $group_id => $migration_list) {
      /** @var \Drupal\migrate_plus\Entity\MigrationGroup $group */
      $group = $this->entityTypeManager->getStorage('migration_group')->load($group_id);
      $group_name = !empty($group) ? "{$group->label()} ({$group->id()})" : $group_id;

      foreach ($migration_list as $migration_id => $migration) {
        if ($names_only) {
          $table[] = [
            'group' => dt('Group: @name', ['@name' => $group_name]),
            'id' => $migration_id,
          ];
        }
        else {
          try {
            $map = $migration->getIdMap();
            $imported = $map->importedCount();
            $source_plugin = $migration->getSourcePlugin();

            // Ajout méthode custom WIKILEX.
            if (method_exists($source_plugin, 'setCid')) {
              $source_plugin->setCid($options['cid']);
            }
          }
          catch (\Exception $e) {
            $this->logger()->error(
              dt(
                'Failure retrieving information on @migration: @message',
                ['@migration' => $migration_id, '@message' => $e->getMessage()]
              )
            );
            continue;
          }

          try {
            $source_rows = $source_plugin->count();
            // -1 indicates uncountable sources.
            if ($source_rows == -1) {
              $source_rows = dt('N/A');
              $unprocessed = dt('N/A');
            }
            else {
              $unprocessed = $source_rows - $map->processedCount();
            }
          }
          catch (\Exception $e) {
            $this->logger()->error(
              dt(
                'Could not retrieve source count from @migration: @message',
                ['@migration' => $migration_id, '@message' => $e->getMessage()]
              )
            );
            $source_rows = dt('N/A');
            $unprocessed = dt('N/A');
          }

          $status = $migration->getStatusLabel();
          $migrate_last_imported_store = $this->keyValue->get(
            'migrate_last_imported'
          );
          $last_imported = $migrate_last_imported_store->get(
            $migration->id(),
            FALSE
          );
          if ($last_imported) {
            $last_imported = $this->dateFormatter->format(
              $last_imported / 1000,
              'custom',
              'Y-m-d H:i:s'
            );
          }
          else {
            $last_imported = '';
          }
          $table[] = [
            'group' => $group_name,
            'id' => $migration_id,
            'status' => $status,
            'total' => $source_rows,
            'imported' => $imported,
            'unprocessed' => $unprocessed,
            'last_imported' => $last_imported,
          ];
        }
      }

      // Add empty row to separate groups, for readability.
      end($migrations);
      if ($group_id !== key($migrations)) {
        $table[] = [];
      }
    }

    return new RowsOfFields($table);
  }

}
