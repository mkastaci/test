<?php

namespace Okanban\Controllers;

class ErrorController extends CoreController {

    public function error404() {
        // AltoDispatcher envoie déjà un header 404 s'il ne trouve pas de route
        //header('HTTP/1.0 404 Not Found');
        // Idéalement, on fait une page 404 dédiée aux couleurs du site
        // Ici, on affiche seulement "Page 404"
        $this->show('404');
    }
}