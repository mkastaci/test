# Identifieurs 

## self

`self` = la classe dans laquelle on a écrit ce mot-clé `self`

```php
<?php

class ClassName {
    const MA_CONSTANTE = 'toto';

    public function myMethod() {
        // self = identifieur de la classe dans laquelle on a écrit self => ClassName
        // => ClassName::MA_CONSTANTE
        // => 'toto'
        echo self::MA_CONSTANTE;
    }
}

```

## $this

`$this` = l'objet courant, c'est-à-dire l'objet depuis lequel on appelle la méthode

## static

L'identifieur de classe `static` cible la classe depuis laquelle on a appelé la méthode statique ou la propriété statique.
Ce mot-clé n'a pas de rapport direct avec les propriétés et méthodes statiques.
`static` est un identifieur de classe qui permet d'identifier une classe "enfant".

```php
<?php

class ParentClassName {
    public static function myMethod() {
        // self = identifieur de la classe dans laquelle on a écrit self => ParentClassName
        // => NON
        // $this = objet => interdit dans une méthode statique
        // => NON
        // Pour cibler la classe depuis laquelle on appelle la méthode : static
        echo static::MA_CONSTANTE;
    }
}

```

```php
<?php

class ClassName extends ParentClassName {
    const MA_CONSTANTE = 'toto';
}
```

```php
<?php

class OtherClassName extends ParentClassName {
    const MA_CONSTANTE = 'tata';
}
```

```php
<?php

// On appelle myMethod depuis la classe ClassName
ClassName::myMethod(); // => static = ClassName => toto
// On appelle myMethod depuis la classe OtherClassName
OtherClassName::myMethod(); // => static = OtherClassName => tata

```
