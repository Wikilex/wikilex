<?php

namespace Drupal\toolbar_menu\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Functional tests for crop API.
 *
 * @group toolbar_menu
 */
class ToolbarMenuFonctionalTest extends WebTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = ['toolbar_menu', 'toolbar'];

  /**
   * Tests crop type crud pages.
   */
  public function testToolbarMenuCrud() {
    // Anonymous users don't have access to crop type admin pages.
    $this->drupalGet('admin/config/user-interface/toolbar_menu/elements');
    $this->assertResponse(403, "Anonymous user is unauthorized to access settings page");

    // Add a new custom menu.
    $menu_name = 'test_menu';
    $menu_label = 'Test Menu';
    $toolbar_id = 'test_menu_in_toolbar';
    $toolbar_label = 'Test Menu in toolbar';

    $values = [
      'id' => $menu_name,
      'label' => $menu_label,
      'description' => 'Description text',
    ];
    $menu = \Drupal::entityTypeManager()->getStorage('menu')->create($values);
    $menu->save();

    $adminUser = $this->drupalCreateUser([
      'administer toolbar menu',
      'administer permissions',
      'access toolbar',
    ]);

    // Can access pages if logged in and no crop types exist.
    $this->drupalLogin($adminUser);
    $this->drupalGet('admin/config/user-interface/toolbar_menu/elements');
    $this->assertResponse(200, "User with 'administer toolbar menu' role is authorized to access settings page");

    // Create a new toolbar menu element.
    $this->drupalGet('admin/config/user-interface/toolbar_menu/elements/add');
    $create_toolbar_element = [
      'label' => $toolbar_label,
      'id' => $toolbar_id,
      'menu' => $menu_name,
      'rewrite_label' => FALSE,
    ];
    $this->drupalPostForm('admin/config/user-interface/toolbar_menu/elements/add', $create_toolbar_element, t('Save'));

    // Enforce refresh caches.
    drupal_flush_all_caches();

    $rid = $this->createRole(["view $toolbar_id in toolbar"], 'aaaaaa', 'AAAAAAAA');
    $adminUser->addRole($rid);
    $adminUser->save();

    $this->checkPermissions(["view $toolbar_id in toolbar"]);

    $this->drupalGet('/admin/people/permissions');

    $this->drupalGet('<front>');
    $this->assertRaw($toolbar_label, 'Custom menu is viewed in toolbar');

    $this->drupalGet('admin/config/user-interface/toolbar_menu/elements/' . $toolbar_id);
    // Update an existing toolbar menu element.
    $update_toolbar_element = [
      'rewrite_label' => TRUE,
    ];
    $this->drupalPostForm('admin/config/user-interface/toolbar_menu/elements/' . $toolbar_id, $update_toolbar_element, t('Save'));

    $this->drupalGet('<front>');
    $this->assertRaw($menu_name, 'Custom menu is viewed in toolbar');

  }

}
