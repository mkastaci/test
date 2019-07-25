<?php

namespace Okanban\Controllers;

use Okanban\Models\CardModel;

class CardController extends CoreController {

    // Méthode pour afficher toutes les cartes disponibles
    public function getAllCards() {
        $cardModel = new CardModel();
        $allCards = $cardModel->findAll();

        // On affiche la réponse en appelant la méthode showJson
        // qui va encoder notre carte de CardModel en json
        $this->showJson($allCards);
    }
}