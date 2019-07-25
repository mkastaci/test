# mot clé static 

## propriété

Une propriété statique est une variable attachée à la classe.  
Elle est indépendante de l'objet.  
Voir le fichier proprietes.md

## méthode

Une méthode statique est une méthode qui ne dépend pas du tout de l'objet courant.  
L'objet courant étant `$this` en PHP, une méthode qui ne contient aucune référence à `$this` dans son corps, **peut** être déclarée _statique_.

```php
<?php

class ClassName {
    // déclaration d'une méthode statique
    public static function toto() {
        return 42;
    }
    // ...
}

```

```php
<?php

echo ClassName::toto(); // => 42

```

## identifieur de classe

Le mot-clé peut aussi identifier une classe. Voir identifieurs.md