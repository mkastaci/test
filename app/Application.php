<?php

// On définit ici le namespace dans lequel se trouve la classe Application
// On a défini dans le fichier composer.json que la racine de notre namespace
// était Okanban et que celle-ci pointe vers le répertoire 'app'
// Mon fichier Application.php étant à la racine de 'app',
// le namespace associé à ma classe application est donc Okanban
namespace Okanban;

use AltoRouter;
use Dispatcher;

class Application {

    const ROUTES = array(
        // Views
        array('GET' ,'/', '\Okanban\Controllers\MainController::home','home'), 
        array('GET' ,'/test', '\Okanban\Controllers\MainController::test','test'), 

        // Lists
        array('GET' ,'/lists','\Okanban\Controllers\ListController::getAllLists','lists'),
        array('POST', '/lists/add', '\Okanban\Controllers\ListController::addList', 'list_add'),
        array('GET' , '/lists/[i:id]', '\Okanban\Controllers\ListController::getList', 'list_view'),
        array('POST', '/lists/[i:id]/update', '\Okanban\Controllers\ListController::updateList', 'list_update'),
        array('POST', '/lists/[i:id]/delete', '\Okanban\Controllers\ListController::deleteList', 'list_delete'),

        // Lists / Cards
        array('POST', '/lists/[i:id]/cards/add', '\Okanban\Controllers\ListController::addCard', 'list_add_card'),
        array('POST', '/lists/[i:id]/cards', '\Okanban\Controllers\ListController::getCards', 'list_get_cards'),
        
        // Cards
        array('GET' , '/cards', '\Okanban\Controllers\CardController::getAllCards', '/cards'),
        array('POST', '/cards/[i:id]/update', '\Okanban\Controllers\CardController::updateCard', 'card_update'),
        array('POST', '/cards/[i:id]/delete', '\Okanban\Controllers\CardController::deleteCard', 'card_delete'),

        // Labels
        array('GET' , '/labels', '\Okanban\Controllers\LabelController::getAllLabels', 'labels'),
        array('POST', '/labels/add', '\Okanban\Controllers\LabelController::addLabel', 'label_add'),
        array('POST', '/labels/[i:id]/update', '\Okanban\Controllers\LabelController::updateLabel', 'label_update'),
        array('POST', '/labels/[i:id]/delete', '\Okanban\Controllers\LabelController::deleteLabel', 'label_delete'),

        // Cards / Labels
        array('GET', '/cards/[i:id]/labels', 'CardLabelController::getCardLabels', 'card_get_labels'),
        array('GET', '/cards/[i:id]/labels/add', 'CardLabelController::addLabelToCard', 'card_add_label'),
        array('GET', '/cards/[i:id]/labels/[i:id]/delete', 'CardLabelController::deleteLabelFromCard', 'card_delete_label'),
    );

    protected $router;

    // ma fonction __construct est une fonction dite magique
    // celle-ci est automatiquement appelée lorsque ma classe est instanciée
    // autrement dit lorsque l'on fait un new Application();
    public function __construct() {
        // On crée l'instance d'AltoRouter
        $this->router = new AltoRouter();

        // Comme nous avons tous une structure de répertoire différente,
        // on utilise $_SERVER['BASE_URI'] pour trouver l'URI dynamiquement de notre site
        // Pour reformuler un peu sur le basePath: ça lui permet de savoir quelle partie de l'URL ignorer pour se concentrer sur ce qui est susceptible de changer d'une adresse à l'autre
         $baseUri = isset($_SERVER['BASE_URI']) ? $_SERVER['BASE_URI'] : '';
        $this->router->setBasePath($baseUri);

        // On définit le mapping des routes
        //$this->defineRoutes(); // Obsolète => altoRouter le fait
        // AltoRouter nous permet de mapper toutes les routes en mettant
        // grâce à addRoutes() qui prend en paramètre un tableau de routes
        $this->router->addRoutes(self::ROUTES);
    }

    public function run() {
        // On essaye de regarder si la route existe ?
        $match = $this->router->match();

        //dump($match);

        // Nouvelle méthode de dispatch avec AltoDispatcher
        // Dispatcher prend un premier paramètre qui est le résultat du match
        // d'AltoRouter et en 2ème paramètre le nom du controller et de la méthode à appeler en si on n'a pas trouvé la route
        $dispatcher = new Dispatcher($match, '\Okanban\Controllers\ErrorController::error404');
        $dispatcher->dispatch();
        
        // Méthode utilisée chez les reds
        // Si $router->match() ne trouve pas de route : il retourne false
        // Sinon, il retourne un tableau avec les données définies dans les mappings précédents (nom du controller et nom de la méthode), le paramètre id trouvé dans l'url, et enfin le nom de la route
        //dump($match);
        /*if ($match === false) { // je ne trouve pas la route => 404
            // On envoie une entête HTTP afin de dire que navigateur que cette page n'existe pas
            header('HTTP/1.0 404 Not Found');
            // Idéalement, on fait une page 404 dédiée aux couleurs du site
            // Ici, on affiche seulement "Page 404"
            echo 'Page 404';
        } 
        // Altorouter a trouvé une route
        else {
            // On récupère les infos nécessaires au DISPATCH
            // nom du controlleur + nom de la méthode
            $routeInfos = $match['target'];
            // On stocke dans une variable toutes les données dynamiques de l'URL
            $urlParams = $match['params'];
            //dump($urlParams['id_product']);
            $controllerName = $routeInfos['controller']; // CatalogController
            $methodName = $routeInfos['method']; // category

            $controller = new $controllerName($this->router);
            $controller = new CatalogController($this->router);
            $controller->$methodName($urlParams);
            $controller->category($urlParams);

        }*/
        
    }

    /*protected function defineRoutes() {

        // Méthode classique
        // On "mappe" les routes du site
        // méthode map sur l'objet AltoRouter
        $this->router->map(
            'GET', // Argument #1 : méthode HTTP => GET ou POST
            '/',   // Argument #2 : l'URL (relative) (ou pattern d'URL)
                // Argument #3 : les infos nécessaires pour "dispatcher" (target)
            '\Okanban\Controllers\MainController::home', // format de route pour AltoDispatcher
            
            // ancien format de route avant AltoDispatcher
            //[
            //    'controller' => '\Okanban\Controllers\MainController',
            //    'method' => 'home'
            //],
            'home' // Argument #4 : le nom de la route (utile plus tard quand on prendra la route en sens inverse :p)
        );
        $this->router->map(
            'GET',
            '/test/',
            '\Okanban\Controllers\MainController::test',
            'test'
        );

        // Récupération des données de toutes les listes
        $this->router->map(
            'GET',
            '/lists',
            '\Okanban\Controllers\ListController::list',
            'list_all_lists' // le 4ème paramètre sert d'identifiant de la route
                             // et peut permettre de générer l'url de cette route
        );
        //dump($this->router->generate('list_all_lists'));
        

        // Je m'appuie sur le tableau des routes qui a été défini
        // dans la constante de class ROUTES
        // Je parcours toutes ces routes une à une et j'appelle la méthode
        // map() sur altoRouter
        foreach(self::ROUTES as $route) {
            $httpMethod = $route[0];
            $relativeUrl = $route[1];
            // Je double les '\' car je suis dans une chaine de caractères
            $controllerAndMethod = '\\Okanban\\Controllers\\'.$route[2];
            $routeId = $route[3];
            $this->router->map(
                $httpMethod,
                $relativeUrl,
                $controllerAndMethod,
                $routeId
            );
        }
    }*/
}
