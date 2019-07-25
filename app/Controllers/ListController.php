<?php

namespace Okanban\Controllers;

use Okanban\Models\ListModel;

class ListController extends CoreController {

    // Méthode pour afficher toutes les listes disponibles
    public function getAllLists() {
        $listModel = new ListModel();
        $allLists = $listModel->findAll();

        // On affiche la réponse en appelant la méthode showJson
        // qui va encoder notre liste de ListModel en json
        $this->showJson($allLists);
    }
}