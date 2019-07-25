<?php

namespace Okanban\Models;

// Ici, pas besoin de '\' devant Okanban ou PDO car on part toujours de la racine
// avec 'use'
use Okanban\Utils\Database;
use PDO;

class ListModel extends CoreModel {

    /**
     * Name of the list
     * 
     * @var string
     */
    protected $name;

    /**
     * The order of the list in the page
     * 
     * @var int
     */
    protected $pageOrder;

    /**
     * @var string
     */
    // La propriété $tableName n'a pas de lien/ n'est pas stockée en base de donnée
    // C'est une propriété spécifique pour ma classe
    // Ici, avec static, ma propriété appartient à la classe ListModel
    // Chaque objet instancié n'a plus sa propre propiété $tableName
    //public static $tableName = 'list';

    // A la place d'une propriété static associé à ma classe,
    // si cette propriété ne doit pas changer de valeur
    // j'utilise une constante
    // Les constantes sont toujours public
    // On le nomme en majuscules sans '$' avec un sépateur éventuelle '_'
    // Il n'est pas possible de changer la valeur d'une constante
    const TABLE_NAME = 'list';

    // L'ordre de tri par défaut pour mes requêtes sur ListModel
    // Avec static, je peux changer la valeur de la propriété
    public static $defaultOrderBy = 'pageOrder';

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param int $newName
     */
    public function setName($newName) {
        $this->name = $newName;
    }

    /**
     * @return int
     */
    public function getPageOrder() {
        return $this->pageOrder;
    }

    /**
     * @param int $newPageOrder
     */
    public function setPageOrder($newPageOrder) {
        $this->pageOrder = $newPageOrder;
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
            INSERT INTO " . self::TABLE_NAME . " (name, page_order)
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
     * Méthode permettant de récupérer un objet ListModel à partir de son ID
     * 
     * @param int $listId
     * 
     * @return ListModel
     */
    public function find($listId) {
        // Saison 5
        // On prépare le code de la requête SQL
        /*$sql = "
            SELECT id, name, page_order AS pageOrder, created_at AS createdAt, updated_at AS updatedAt
            FROM list
            WHERE id = {$listId}
        ";
        // J'exécute ma requête SQL et je récupère ma boite de résultats (pdoStatement)
        $pdoStatement = Database::getPDO()->query($sql);*/

        // Saison 6 : version sécurisée
        $sql = "
            SELECT id, name, page_order AS pageOrder, created_at AS createdAt, updated_at AS updatedAt
            FROM ".self::TABLE_NAME."
            WHERE id = :id
        ";

        // Préparation de la requête
        $pdoStatement = Database::getPDO()->prepare($sql);

        // Désormais, je dois donner une valeur (et un type) pour chaque jeton
        $pdoStatement->bindValue(':id', $listId, PDO::PARAM_INT);

        // et une fois les bindValue effectués, j'exécute
        $pdoStatement->execute();

        // On souhaite récupérer le résultat sous la forme d'un objet
        // de la classe ListModel
        $listModel = $pdoStatement->fetchObject('\Okanban\Models\ListModel');
        
        // Je retourne l'objet ListModel correspondant
        return $listModel;
    }

    /**
     * Méthode permettant de mettre à jour une liste dans la BDD à partir 
     * de l'objet courant
     * 
     * @return bool
     */
    public function update() {
        // NOW() permet de récupérer la date et l'heure au moment de l'insertion
        // dans la base
        // https://www.w3schools.com/sql/func_mysql_now.asp
        $sql = "
            UPDATE ".self::TABLE_NAME."
            SET name = :name, page_order = :pageOrder, updated_at = NOW()
            WHERE id = :id
        ";

        $pdoStatement = Database::getPDO()->prepare($sql);

        $pdoStatement->bindValue(':id', $this->id, PDO::PARAM_INT);

        $pdoStatement->bindValue(':name', $this->name, PDO::PARAM_STR);
        $pdoStatement->bindValue(':pageOrder', $this->pageOrder, PDO::PARAM_INT);

        $pdoStatement->execute();

        // On récupère le nombre de lignes affectées (supprimées)
        $affectedRows = $pdoStatement->rowCount();
        //dump($affectedRows);

        // On retourne vrai, si au moins une ligne affectées
        // Si j'ai affecté plus d'une ligne, je retourne true
        // sinon je retourne false
        // Je m'assure que ma requête a modifié au moins une ligne 
        // dans la table list
        return ($affectedRows > 0);
    }

    /**
     * Méthode permettant de retourner un tableau d'objets ListModel
     * représentant toutes les lignes de la table list
     * 
     * @return ListModel[]
     */
    public function findAll() {
        $sql = "
            SELECT id, name, page_order AS pageOrder, created_at AS createdAt, updated_at AS updatedAt
            FROM ".self::TABLE_NAME."
            ORDER BY ". self::$defaultOrderBy . " ASC
        ";

        // Ici, pas de risque d'injection SQL, car aucune donnée dynamique
        // dans ma requête, je peux donc utiliser query()
        $pdoStatement = Database::getPDO()->query($sql);

        // On récupère les résultats
        // Cela nous génère un tableau d'objet ListModel
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, '\Okanban\Models\ListModel');

        return $results;
    }

    // Méthode permettant à json_encode de lire les données de mon objet
    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'pageOrder' => $this->pageOrder
            // Je ne veux pas fournir toutes mes propriétés
            // je peux donc choisir uniquement celle que je veux retourner
        ];
    }
}
