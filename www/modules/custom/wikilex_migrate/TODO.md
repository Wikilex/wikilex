 
* Gérer l'import d'un seul code (avec articles et sections), avec sélection sur le cID. 
  - Migrate Manifest.  A tester
* Gérer l'autoréférence pour les sections
 (Peut être non nécessaire si on arrive à gérer Book) .
* Régler les plugins et configs pour l'import de tous les champs, une fois ceux ci crées.


## Régler l'import pour les books.

Comment réaliser une importation dans une entité book, avec 3 content types différents ?
  
Créer un plugin de process spécial !
Chaque article ,section , et code a une clé legi unique. Il suffit de faire une requete SQL,
et on obtient la node et son nid !


Par contre a moins de créer une Source custom faisant une requete sur les 3 tables différentes, 
Il faut créer trois schema de migrations YML . book.articles.yml par exemple.
Bien sur il faut forcer les dépendances des autres migrations pour qu'elles soient faites avant.

BIen que cela soient les mêmes tables chez legi-php, que pour les content-types,
la préparation et les fields sont vraiments différents.
Et pour connaître les 



### Régler l'import dans le menu principal pour les nodes codes_de_loi (bonus)

### Import de configuration objects
https://www.drupal.org/docs/8/api/migrate-api/migrate-destination-plugin-examples/migrate-destination-config-plugin
