<?php

namespace Okanban\Models;

// Ici, pas besoin de '\' devant Okanban ou PDO car on part toujours de la racine
// avec 'use'
use Okanban\Utils\Database;
use PDO;

class CardModel extends CoreModel {

    /**
     * title of the list
     * 
     * @var string
     */
    protected $title;

    /**
     * The order of the card in the list
     * 
     * @var int
     */
    protected $listOrder;

    /**
     * The id of my list
     * 
     * @var int
     */
    protected $listId;

    const TABLE_NAME = 'card';

    /**
     * @return string
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @param int $newTitle
     */
    public function setName($newTitle) {
        $this->title = $newTitle;
    }

    /**
     * @return int
     */
    public function getListOrder() {
        return $this->listOrder;
    }

    /**
     * @param int $newListOrder
     */
    public function setListOrder($newListOrder) {
        $this->listOrder = $newListOrder;
    }

    /**
     * @return int
     */
    public function getListId() {
        return $this->listId;
    }

    /**
     * @param int $newListId
     */
    public function setListId($newListId) {
        $this->listId = $newListId;
    }
    
    // #################################################################
    // Active Record : définition des méthodes CRUD
    // #################################################################

    /**
     * Méthode permettant d'ajouter une ligne dans la table list
     * à partir des données de l'objet courant
     * 
     * @return bool
     */
    public function insert() {
        // Méthode saison 5
        // On prépare le code de la requête SQL
        /*$sql = "
            INSERT INTO list (name, page_order)
            VALUES ('{$this->name}', {$this->pageOrder})
        ";

        // J'exécute ma requête SQL et je récupère ma boite de résultats (pdoStatement)
        $pdoStatement = Database::getPDO()->exec($sql);*/

        // Méthode saison 6 : plus sécurisée afin d'empêcher les injections SQL
        // https://www.php.net/manual/fr/security.database.sql-injection.php
        // Les placeholders :name et :pageOrder permettent de définir l'endroit où 
        // seront remplacées les valeurs à insérer
        $sql = "
            INSERT INTO list (name, page_order)
            VALUES (:name, :pageOrder)
        ";

        // On prépare la requête, à ce stade, elle n'est pas exécutée
        $pdoStatement = Database::getPDO()->prepare($sql);

        // On définit les valeurs pour chaque placeholder
        $pdoStatement->bindValue(':name', $this->name, PDO::PARAM_STR);
        $pdoStatement->bindValue(':pageOrder', $this->pageOrder, PDO::PARAM_INT);

        // On exécute la requête
        $pdoStatement->execute();

        // On récupère le nombre de lignes affectées (insérées)
        $affectedRows = $pdoStatement->rowCount();
        dump($affectedRows);

        $lastInsertId = Database::getPDO()->lastInsertId();

        dump($lastInsertId);
        // Si $lastInsertId est plus grand que 0, j'ai réussi à insérer
        if ($lastInsertId > 0) {
            return true;
        }
        // Sinon, l'insertion a échouée
        else {
            return false;
        }
    }

    /**
     * Méthode permettant de récupérer un objet CardModel à partir de son ID
     * 
     * @param int $cardId
     * 
     * @return CardModel
     */
    public function find($cardId) {
        // Saison 6 : version sécurisée
        $sql = "
            SELECT id, title, list_order AS listOrder, list_id AS listId, created_at AS createdAt, updated_at AS updatedAt
            FROM ".self::TABLE_NAME."
            WHERE id = :id
        ";

        // Préparation de la requête
        $pdoStatement = Database::getPDO()->prepare($sql);

        // Désormais, je dois donner une valeur (et un type) pour chaque jeton
        $pdoStatement->bindValue(':id', $cardId, PDO::PARAM_INT);

        // et une fois les bindValue effectués, j'exécute
        $pdoStatement->execute();

        // On souhaite récupérer le résultat sous la forme d'un objet
        // de la classe CardModel
        $cardModel = $pdoStatement->fetchObject('\Okanban\Models\CardModel');
        
        // Je retourne l'objet CardModel correspondant
        return $cardModel;
    }

    /**
     * Méthode permettant de mettre à jour une carte dans la BDD à partir 
     * de l'objet courant
     * 
     * @return bool
     */
    public function update() {
        // NOW() permet de récupérer la date et l'heure au moment de l'insertion
        // dans la base
        // https://www.w3schools.com/sql/func_mysql_now.asp
        $sql = "
            UPDATE card
            SET title = :title, list_order = :listOrder, updated_at = NOW()
            WHERE id = :id
        ";

        $pdoStatement = Database::getPDO()->prepare($sql);

        $pdoStatement->bindValue(':id', $this->id, PDO::PARAM_INT);

        $pdoStatement->bindValue(':title', $this->title, PDO::PARAM_STR);
        $pdoStatement->bindValue(':listOrder', $this->listOrder, PDO::PARAM_INT);

        $pdoStatement->execute();

        // On récupère le nombre de lignes affectées (supprimées)
        $affectedRows = $pdoStatement->rowCount();
        //dump($affectedRows);

        // On retourne vrai, si au moins une ligne affectées
        // Si j'ai affecté plus d'une ligne, je retourne true
        // sinon je retourne false
        // Je m'assure que ma requête a modifié au moins une ligne 
        // dans la table card
        return ($affectedRows > 0);
    }

    /**
     * Méthode permettant de retourner un tableau d'objets CardModel
     * représentant toutes les lignes de la table card
     * 
     * @return CardModel[]
     */
    public function findAll() {
        $sql = "
            SELECT id, title, list_order AS listOrder, created_at AS createdAt, updated_at AS updatedAt, list_id AS listId
            FROM card
        ";

        // Ici, pas de risque d'injection SQL, car aucune donnée dynamique
        // dans ma requête, je peux donc utiliser query()
        $pdoStatement = Database::getPDO()->query($sql);

        // On récupère les résultats
        // Cela nous génère un tableau d'objet CardModel
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, '\Okanban\Models\CardModel');

        return $results;
    }

    public function jsonSerialize(){
        $data = [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'listOrder' => $this->getListOrder(),
            'listId' => $this->getListId()
        ];

        return $data;
    }

}
