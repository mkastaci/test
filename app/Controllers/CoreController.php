<?php

namespace Okanban\Controllers;

abstract class CoreController {

    protected $router;

    public function __construct() {
        //$this->router = $router;
    }

    // Tous mes controllers peuvent avoir besoin d'une méthode pour rediriger
    // donc je crée la méthode dans le CoreController
    protected function redirect($url) {
        header('Location: '.$url);
        exit;
    }

    protected function show($viewName, $viewVars = array()) {
        // On peut rajouter l'information sur la base uri
        // dans la variable $viewVars qui est accessible
        // dans l'ensemble des fichiers template
        $baseUri = isset($_SERVER['BASE_URI']) ? $_SERVER['BASE_URI'] : '';
        $viewVars['base_uri'] = $baseUri;

        // viewVars est un tableau fourre-tout, nombre de données indéfini
        // dans la view, on pourra ainsi faire référence à ces variables
        // extract fonctionne uniquement si je nomme correctement mes clés/index avec des chaines de caractères qui ne commencent pas par un nombre
        extract($viewVars);

        // Je rajoute la variable $router pour la rendre accessible dans les différentes vues
        $router = $this->router;
        
        // $viewVars est disponible dans chaque fichier de vue
        require(__DIR__.'/../views/header.tpl.php');
        require(__DIR__.'/../views/'.$viewName.'.tpl.php');
        require(__DIR__.'/../views/footer.tpl.php');
    }

    /**
    * Méthode permettant d'afficher/retourner un JSON à l'appel Ajax effectué
    *
    * @param mixed $data
    */
    protected function showJson($data)
    {
        // Autorise l'accès à la ressource depuis n'importe quel autre domaine
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Credentials: true');
        // Dit au navigateur que la réponse est au format JSON
        header('Content-Type: application/json');
        // La réponse en JSON est affichée
        echo json_encode($data);
        // Exemple de déroulement du json_encode pour la tableau contenant
        // toutes les listes (tableau de ListModel)
        // - on parcourt les objets ListModel un par un
        // - pour chaque ListModel : je regarde si la classe ListModel
        // implémente JsonSerializable, si oui, j'appelle la méthode jsonSerialize
        // sur ce ListModel et récupère le résultat retourné pour l'ajouter à mon json résultat
        // - Si la classe ListModel n'implémentait pas JsonSerializable, 
        // j'essaierai d'accéder aux propriétés de la classe mais comme elles sont
        // protected, je retourne un résultat vide.
    }

}