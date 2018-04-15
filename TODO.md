# Liste des choses à faire dans Wikilex

### Import depuis Legi-php
* Réaliser l'import
  * Avec seulement le texte, titre, clé legi et reférences dans un 1er temps
  * Avec une arborescence de Book dans un second temps.
  * Avec la taxonomie dans un troisième temps. A faire après la création d'une entité de config pour les codes
      * Importance = Très haute.

* Créer la commande de migration custom pour passer CID en paramètres.
      * Importance = Très haute.
      
* Préserver les modifications apportés sur certains champs lors de supdates et en écraser d'autres.
  *  overwrite_properties: à passer dans le yml     

* Attribuer les migrations à l'user import.

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

### Facets 
* On ne vas pas insérer dans la vue 70+ facets de tags. Il faut trouver un moyen de dérivation. Une réponse AJAX, si on sélectionne un des codes de lois,
alors les blocks de tags spéciaux s'affichent ? 


 
### Menus
* Gestion des books-menus
 

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