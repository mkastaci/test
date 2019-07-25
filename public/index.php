<?php

// Etape primordiale, inclure les dépendances Composer dans notre projet
require(__DIR__ . '/../vendor/autoload.php');
// Controllers
/*require(__DIR__.'/../app/Controllers/CoreController.php');
require(__DIR__.'/../app/Controllers/MainController.php');
require(__DIR__.'/../app/Controllers/ErrorController.php');
// Models
require(__DIR__.'/../app/Models/CoreModel.php');
// Utils
require(__DIR__.'/../app/Utils/Database.php');
// Application
require(__DIR__.'/../app/Application.php');*/


/*function noClassFoundCallback($unfoundClassName) {
    echo 'fonction noClassFoundCallback';
    // $unfoundClassName contient le nom de la classe que Php
    // n'a pas pu instancier car le fichier contenant la classe n'était pas inclus
    var_dump($unfoundClassName);
    // Cette fonction peut nous servir à aller chercher les fichiers à inclure

    // Algorithme chargé d'aller chercher dans les répertoires du projet
    // le bon fichier incluant la classe à instancier

    // Tu n'as pas trouvé la classe
    // Essayons d'inclure le fichier de cette classe

    // Je teste que $unfoundClassName contient la chaine 'Controller'
    //if ($unfoundClassName contient 'Controller') {
    if (preg_match("/Controller/i", $unfoundClassName)) {
        // Alors je vais chercher dans le répertoire app/Controllers/
        // le fichier correspondant
        require(__DIR__.'/../app/Controllers/'.$unfoundClassName.'.php');
    }
    // Je teste que $unfoundClassName contient la chaine 'Model'
    else if (preg_match("/Model/i", $unfoundClassName)) {
        // Alors je vais chercher dans le répertoire app/Models/
        // le fichier correspondant
        require(__DIR__.'/../app/Models/'.$unfoundClassName.'.php');
    }
    else {
        require(__DIR__.'/../app/'.$unfoundClassName.'.php');
    }
}

// L'appel de la méthode spl_autoload_register permet
// de définir une fonction à appeler lorsque Php essaye d'instancier 
// une classe qu'il ne connait pas encore (dans le cas où on a pas fait 
// les requires)
// Un peu similaire à l'ajout d'un évènement en javascript
spl_autoload_register('noClassFoundCallback');*/


// On instancie l'application
$application = new \Okanban\Application();

// On lance l'application
$application->run();

// Ceci est mon frontcontroller
//echo 'Je suis ton FrontController';
//exit;