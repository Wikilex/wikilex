# Liste des choses à faire dans Wikilex

### Gestion des Types de Contenus
* Sections
  * Titre trop longs pour certaines sections. Création d'un field titre entier, qu'il faudra afficher à la place du titre normal.
  

* Pour code de lois
 * Extrafield faisant une liste des sections et articles lui appartenant ?
   * Peut etre géré par Book arborescence normalement.

* Creation de widgets spéciaux pour entity_ref 
  * Widget pour ref des codes de lois
  * Widget pour ref des sections
  * Contrainte de validation sur Clé LEGI.
  

### Taxonomie
* Creations des vocabulaires 
* Trouver comment gérer la création de vocabulaires de manière automatisé
    * Module spécialisé avec une Form pour la configuration.
    * Surement avec Migrate... 

### Facets 
* On ne vas pas insérer dans la vue 70+ facets de tags. Il faut trouver un moyen de dérivation. Une réponse AJAX, si on sélectionne un des codes de lois,
alors les blocks de tags spéciaux s'affichent ? 
 


 
### Menus
* Gestion des books-menus
 
    
### Import depuis Legi-php
* Réaliser l'import
  * Avec seulement le texte, titre, clé legi et reférences dans un 1er temps
  * Avec une arborescence de Book dans un second temps.
  * Avec la taxonomie dans un troisième temps


### Flags
* Activater le module et le configurer


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