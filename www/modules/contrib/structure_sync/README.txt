================================ Structure Sync ================================

Structure sync provides Drush commands and admin interface screens for
synchronising content that could also be considered configuration. Including
menu items, custom blocks and taxonomy terms.

The available Drush commands are:
'export-taxonomies' ('et') - Export taxonomy terms to configuration
'import-taxonomies' ('it') - Import taxonomy terms from configuration
'export-blocks'     ('eb') - Export custom blocks to configuration
'import-blocks'     ('ib') - Import custom blocks from configuration
'export-menus'      ('em') - Export menu links to configuration
'import-menus'      ('im') - Import menu links from configuration
'export-all'        ('ea') - Export taxonomy terms, custom blocks and menu links
                             to configuration
'import-all'        ('ia') - Import taxonomy terms, custom blocks and menu links
                             from configuration

The available admin interface screens are:
/admin/structure/structure-sync/general    - General options for this module
/admin/structure/structure-sync/taxonomies - Import/export taxonomy terms
/admin/structure/structure-sync/blocks     - Import/export custom blocks
/admin/structure/structure-sync/menu-links - Import/export menu links
