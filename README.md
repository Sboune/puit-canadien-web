puit-canadien-web
=================

Projet de création d'un site web pour exploiter (visualiser, comparer) les données des sondes d'un puit canadien.

##Règles d'utilisation de git
Il est impératif de respecter les règles d'utilisation de git documentées dans le fichier `Guide-git.pdf`

## Configuration du fichier `admin/config.php`
Vous devez avoir un fichier `config.php` dans le dossier admin, contenant les informations de connexion à votre base de données MySQL.

```php
<?php
  define('HOST', 'localhost');
  define('USER', 'user');
  define('PASS', 'mdp');
  define('BASE', 'nom_de_la_base');
?>
```