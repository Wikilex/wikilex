# Principe de wikilex

Wikilex a pour but d'être un outil collaboratif sur les lois.
Une version live (encore en construction) est visible ici : https://www.wikilex.xyz/

Pour une présentation approfondie de l'idée, vous pouvez la visionner ici : [Présentation prezi](https://prezi.com/ncow2w-v8opb/wikilex/).

[And a english presentation here](https://prezi.com/kvmngpsceafa/wikilex-english/)


# Installation

Vous pouvez téléchargez une version zip du projet en cliquant sur [ce lien](https://github.com/Wikilex/wikilex/archive/master.zip).

Ou bien cloner le projet via git, avec la commande

````
git clone https://github.com/Wikilex/wikilex.git
````

Créer une base de données et importer dedans le contenu du dump **wikilex.sql.gz** .

Dans le dossier /conf/drupal, faire une copie du fichier local.example.php, en la renommant local.php
A l'intérieur de local.php, changer les identifiants exemples de connection à la database, pour ceux vers 
la base de données que vous venez de créer.

Lancer ensuite le script (en ligne de commande) :
```
./scripts/deploy.sh
```

