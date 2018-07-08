<?php

namespace Drupal\wikilex_migrate\Plugin\migrate\source;

use Drupal\migrate\Plugin\migrate\source\SqlBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\State\StateInterface;
use Drupal\migrate\Plugin\MigrationInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\wikilex_codes\CodesListe;

abstract class ImportWikilex extends SqlBase implements ContainerFactoryPluginInterface {

  /**
   * Le service codes_liste
   *
   * @var string
   */
  protected $codesListe;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, MigrationInterface $migration, StateInterface $state, CodesListe $codes_liste ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $migration, $state);
    $this->codesListe = $codes_liste;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition, MigrationInterface $migration = NULL) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $migration,
      $container->get('state'),
      $container->get('codes_liste')
    );
  }
}
