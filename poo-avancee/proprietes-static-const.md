# Propriétés 

## Propriétés "classiques"

Une propriété est une variable attachée à l'objet.  
Si je modifie la valeur d'une propriété sur un objet, ça ne modifie pas les autres objets.

```php
<?php

class ClassName {
    public $property;
    // ...
}

```

```php
<?php

echo $object->property;

```

## Propriétés statiques

Une propriété statique est une variable attachée à la classe.  
Elle est indépendante de l'objet.  
En conséquence, si je modifie la valeur, la modification impacte tous les objets de la classe.  
On utilise des propriétés statiques lorsque la valeur de la propriété est toujours la même, quelque soit l'objet.

```php
<?php

class ClassName {
    public static $property = 'value';
    // ...
}

```

```php
<?php

echo ClassName::$property;

```

## Constantes de classe

C'est comme une propriété statique, sauf qu'on ne peut pas en modifier la valeur. JAMAIS !  
Par convention, les constantes sont en majauscules, et les espaces symbolisés par un `_`.  
Une constante est toujours public.

```php
<?php

class ClassName {
    const MA_CONSTANTE = 'value';
    // ...
}

```

```php
<?php

echo ClassName::MA_CONSTANTE;

```

## `::`

On appelle le `::` :

- Opérateur de résolution de portée (Paamayim Nekudotayim https://fr.wikipedia.org/wiki/Paamayim_Nekudotayim)
