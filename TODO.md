# Liste des choses à faire dans Wikilex

### Import depuis Legi-php

* Création d'un service pour clean après import
  * Has children pour les outlines.
  * Supprimer les outlines avec des sections vides ou avec des articles tous abrogés, ou mortné.
  * Gestion de la weight des outlines.
  * Importance = Très haute.       
      
* Préserver les modifications apportés sur certains champs lors de supdates et en écraser d'autres.
  *  overwrite_properties: à passer dans le yml     


### CONFIG ENTITY TEXTES DE LOIS
* Transformer l'espace de formulaire des codes de lois en une création d'une entité config. 
L'entité config va faire le lien entre les books, les vocabulaires de taxonomies, et les facets (et peut être d'autres choses suivant les besoins).
Le système de dérivation qui sera mis en place reposera dessus.
* Est-il possible d'avoir des bundles d'une entité config ?
  * Importance = Très haute.
  
### Gestion des Types de Contenus
* Sections
  * Titre trop longs pour certaines sections. Création d'un field titre entier, qu'il faudra afficher à la place du titre normal.
      * Importance  : basse

* Pour code de lois
 * Extrafield faisant une liste des sections et articles lui appartenant ?
   * Peut etre géré par Book arborescence normalement.A améliorer suivant besoin.

* Creation de widgets spéciaux (tree) pour entity_ref à partir d'emplacements dans un book ?
  * Importance  : basse
  
* Contrainte de validation sur Clé LEGI.
  

### Taxonomie
* S'assurer une interface claire avec celle de la config des codes. 
* Création d'un service pour Insertion semi-automatique de la taxonomie appropriée suivant les codes. A faire après la création d'une entité de config pour les codes
  * Importance basse.

### Facets 
* On ne vas pas insérer dans la vue 70+ facets de tags. Il faut trouver un moyen de dérivation. Une réponse AJAX, si on sélectionne un des codes de lois,
alors les blocks de tags spéciaux s'affichent ? 


### Flags
* Activater le module et le configurer

### Base données custom
Il va y avoir en tous ces centaines de milliers de nodes, de terms de taxonomies.
Et il y a des tables communes pour toutes les nodes, les books entrées, les termes de taxonomy, les entrées de champ des nodes.
Les tables actuelles ne tiendront pas si on importe toute la législation.
Il faut créér un système de dérivatif pour les tables également.
#### Liste des tables à changer
* book
* taxonomy
  * taxonomy_index
  * taxonomy_term_data
  * taxonomy_term_field_data
  * taxonomy_term_hierarchy


### Theming



### Forum


### Test de modules
 * Taxonomy moderator : https://www.drupal.org/project/taxonomy_moderator
 * Glossify : https://www.drupal.org/project/glossify
 * Menu Token : https://www.drupal.org/project/menu_token
 * Entity Hierarchy : https://www.drupal.org/project/entity_hierarchy
 * Menu Select : https://www.drupal.org/project/menu_select
 * Menus Notifications : https://www.drupal.org/project/menu_notifications
 
 Modules D7 utiles :
 * Book Helper : https://www.drupal.org/project/book_helper
 * Book title override : https://www.drupal.org/project/book_title_override