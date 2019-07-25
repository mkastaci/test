<?php

namespace Okanban\Controllers;

use Okanban\Models\ListModel;
use Okanban\Models\CardModel;
use Okanban\Models\LabelModel;

class MainController extends CoreController {

    public function home() {
        $this->show('home');
    }

    public function test() {
    
        // Je cherche la liste ayant l'id 2
        /*$list = new ListModel();
        $listNumber2 = $list->find(2);
        var_dump($listNumber2->getName());*/

        // Je souhaite créer une nouvelle liste
        /*$newList = new ListModel();
        $newList->setName('Symfony');
        $newList->setPageOrder(5);
        // Insertion de la nouvelle list
        dump($newList->insert());*/

        // On récupère toutes les listes
        /*$list = new ListModel();
        $lists = $list->findAll(); 
        dump($lists);
        foreach($lists as $list) {
            dump($list->getName());
        }*/

        // On récupère toutes les cartes
        /*$card = new CardModel();
        $cards = $card->findAll(); 
        dump($cards);
        foreach($cards as $card) {
            dump($card->getTitle());
        }*/

        // On récupère toutes les labels
        /*$label = new LabelModel();
        $labels = $label->findAll(); 
        dump($labels);
        foreach($labels as $label) {
            dump($label->getName());
        }*/

        // Je cherche le label ayant l'id 3
        /*$label = new LabelModel();
        $labelNumber3 = $label->find(3);
        dump($labelNumber3);
        dump($labelNumber3->getName());*/

        // Suppression d'une liste avec l'id 3
        /*$list = new ListModel();
        // find retourne un objet ListModel avec les propriétés remplies
        // à partir des données de la base
        $listNumber3 = $list->find(3);
        // $listNumber3 est un objet de la classe ListModel
        // contenant les infos de la liste dont l'id est 3
        // Je connais donc mon id de liste et je peux me supprimer tout seul
        // sans avoir à passer en paramètre l'id de la liste
        dump($listNumber3->delete());*/

        // Mise à jour d'une liste
        /*$list = new ListModel();
        $listNumber4 = $list->find(4);
        $listNumber4->setName('Mon nouveau nom de liste');
        $listNumber4->setPageOrder(10);
        dump($listNumber4->update());*/



        /*$list = new ListModel();
        $listNumber1 = $list->find(1);*/

        /*dump($listNumber1);
        dump(ListModel::TABLE_NAME);

        dump($list->findAll());
        ListModel::$defaultOrderBy = 'name';
        dump($list->findAll());*/

        //dump(\PDO::FETCH_CLASS);
        /*$listNumber2 = $list->find(2);
        //$listNumber2->tableName = 'list2';
        $listNumber4 = $list->find(4);
        //$listNumber4->tableName = 'list4';
        dump($listNumber1);
        dump($listNumber2);
        dump($listNumber4);*/

        // Test de suppression avec la méthode delete de CoreModel
        /*$list = new ListModel();
        $listNumber1 = $list->find(1);
        $listNumber1->delete();*/

        /*$card = new CardModel();
        $cardNumber1 = $card->find(1);
        $cardNumber1->delete();*/

        /*$label = new LabelModel();
        $labelNumber1 = $label->find(1);
        $labelNumber1->delete();*/


        // Avec le mot clé abstract sur la classe CoreModel
        // j'empêche à quiconque d'instancier un objet CoreModel
        //$coreModel = new CoreModel(); => génère une erreur PHP
        //dump($coreModel);

        $listModel = new ListModel();
    }
}