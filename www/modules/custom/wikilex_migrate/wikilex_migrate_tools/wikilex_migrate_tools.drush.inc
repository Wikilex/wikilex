<?php

/**
 * Implements hook_drush_command().
 */
function wikilex_migrate_tools_drush_command() {

  $commands['my-example-command'] = [
    'description' => 'This is my example command.',
    'aliases' => ['mec'],
    'arguments' => [
      'arg1' => 'My custom argument 1.',
      'arg2' => 'My custom argument 2.',
    ],
    'options' => [
      'opt1' => 'My custom option.',
    ],
    'examples' => [
      'drush mec' => 'Print my example command.',
      'drush mec myargument' => 'Print my example command with an argument "myargument".',
      'drush mec myargument --opt1=myoption' => 'Print my example command with an argument "myargument" and an option "myoption".',
    ],
  ];

  // TODO Créer la commande pour améliorer drush mi


  return $commands;
}

/**
 * Drush command logic.
 * drush_[MODULE_NAME]_[COMMAND_NAME]().
 */
function drush_wikilex_migrate_tools_my_example_command($arg1 = 'N/A', $arg2 = 'N/A') {
  $opt1 = drush_get_option('opt1', 'N/A');
  $tokens = ['@arg1' => $arg1, '@opt1' => $opt1];
  drush_print(dt('My custom command. Argument: @arg1 Option: @opt1', $tokens));
}


