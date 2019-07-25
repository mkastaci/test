# PSR-4 - Autoloading

## Mise en place

### #1 - configurer l'autoload avec Composer

Dans le fichier composer.json

```js

    "autoload": {
        "psr-4": {
            "NomDuProjet\\": "app/"
        }
    }
```

Puis, pour chaque modification de cette partie "autoload" du fichier composer.json, on exécute la commande :  
`composer dump-autoload`

### #2 - on "place" chaque classe dans un namespace

Au début de chaque classe, on précise le namespace (dossier) dans lequel elle se trouve

Exemple, pour la classe CoreController se situant dans `app/Controllers/CoreController.php`

```php
<?php

namespace NomDuProjet\Controllers;

class CoreController {
    // ...
}

```

### #3 - utilisation de nos classes

Désormais, `CoreController` ne suffit plus pour déterminer la classe `CoreController` qui se situe dans `app/Controllers/CoreController.php`.

On doit préciser son Fully Qualified Class Name (FQCN), c'est-à-dire son "nom absolu" (commençant par `\`).

```php
<?php

// Attention, normalement, un CoreController n'a pas pour but d'être instancié
$core = new \NomDuProjet\Controllers\CoreController();
$coreBis = new \NomDuProjet\Controllers\CoreController();

```

### #4 - créer un raccourci pour le nom des classes

Si on ne souhaite pas définir le FQCN à chaque fois, on peut dire à PHP de créer un "raccourci".

```php
<?php

// On crée le raccourci/alias
// On pourra dire qu'on "importe" la classe
// Le "\" au début est "implicite" et obligatoirement "implicite"
use NomDuProjet\Controllers\CoreController;

// Attention, normalement, un CoreController n'a pas pour but d'être instancié
// Ici, PHP voit le "raccourci" mais, au final, va créer un instance de \NomDuProjet\Controllers\CoreController
$core = new CoreController();
$coreBis = new CoreController();

```

### #5 - Cas des classes natives et sans namespace

Les classes natives de PHP ne sont pas placées dans un namespace.  
Donc, pour les utiliser, le FQCN sera `\PDO` par exemple pour PDO.

D'autres classes peuvent avoir été déclarées sans namespace.  
Dans ce cas, c'est comme pour PDO, le FQCN sera `\NomDeMaClasse`.


## Debug

- vérifier qu'on a bien exécuté `composer dump-autoload`
- vérifier que le use ou le FQCN est correct, à la majuscule près
- vérifier que la classe est bien placée dans le bon namespace
- vérifier que le namespace de la classe est correct, à la majuscule près
