<?php

/**
 * @file
 * Drush common options.
 */

$options['alias-path'] = __DIR__;

$local_file = __DIR__ . '/local.php';
if (file_exists($local_file)) {
  require_once $local_file;
}
