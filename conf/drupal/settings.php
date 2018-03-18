<?php

/**
 * @file
 * Common settings for drupal.
 */

// Reverse proxy configuration is usually not necessary when nginx is correctly
// configured. However, we keep it here for safety.
$settings['reverse_proxy'] = TRUE;
$settings['reverse_proxy_addresses'] = [
  '127.0.0.1',
];

$settings['trusted_host_patterns'] = [
  '^(.*)\.dev\.ows\.fr$',
];

$settings['hash_salt'] = '7A7uAu2zFBFIkis3kuGU2U9apc8V32EL-UIBnwEjHImGMLaBEn5J2bJvxhmCcb6rhOr5aPjkiA';

$settings['install_profile'] = 'minimal';

$config_directories['sync'] = __DIR__ . '/config/sync';

require_once __DIR__ . '/local.php';
