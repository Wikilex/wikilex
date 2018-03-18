<?php

/**
 * @file
 * Contient un exemple de configuration pour un poste local.
 */

$databases['default']['default'] = [
  'host' => 'localhost',
  'driver' => 'mysql',
  'database' => 'db',
  'username' => 'user',
  'password' => 'pass',
];

$settings['trusted_host_patterns'] = [
  '^wikilex-URL\.local\.ows$',
];

$settings['file_private_path'] = DRUPAL_ROOT . '/../drupal_private_files';

// Settings pouvant être utiles en dev :
// - exemple pour désactiver le cache backend,
// - error_level : verbose
// - preprocess css & js : FALSE,
// - twig : debug, auto_reload et non cache.
#include_once __DIR__ . '/inc/development.php';
