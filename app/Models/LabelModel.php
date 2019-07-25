<?php

namespace Okanban\Models;

// Ici, pas besoin de '\' devant Okanban ou PDO car on part toujours de la racine
// avec 'use'
use Okanban\Utils\Database;
use PDO;

class LabelModel extends CoreModel {

    /**
     * Name of the label
     * 
     * @var string
     */
    protected $name;

    const TABLE_NAME = 'label';

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
     * Méthode permettant de récupérer un objet LabelModel à partir de son ID
     * 
     * @param int $labelId
     * 
     * @return LabelModel
     */
    public function find($labelId) {
        $sql = "
            SELECT id, name, created_at AS createdAt, updated_at AS updatedAt
            FROM ".self::TABLE_NAME."
            WHERE id = :id
        ";

        // Préparation de la requête
        $pdoStatement = Database::getPDO()->prepare($sql);

        // Désormais, je dois donner une valeur (et un type) pour chaque jeton
        $pdoStatement->bindValue(':id', $labelId, PDO::PARAM_INT);

        // et une fois les bindValue effectués, j'exécute
        $pdoStatement->execute();

        // On souhaite récupérer le résultat sous la forme d'un objet
        // de la classe LabelModel
        $labelModel = $pdoStatement->fetchObject('\Okanban\Models\LabelModel');
        
        // Je retourne l'objet LabelModel correspondant
        return $labelModel;
    }

    /**
     * Méthode permettant de mettre à jour un label dans la BDD à partir 
     * de l'objet courant
     * 
     * @return bool
     */
    public function update() {
        $sql = "
            UPDATE label
            SET name = :name, updated_at = NOW()
            WHERE id = :id
        ";

        $pdoStatement = Database::getPDO()->prepare($sql);

        $pdoStatement->bindValue(':id', $this->id, PDO::PARAM_INT);

        $pdoStatement->bindValue(':name', $this->name, PDO::PARAM_STR);

        $pdoStatement->execute();

        // On récupère le nombre de lignes affectées (supprimées)
        $affectedRows = $pdoStatement->rowCount();
        //dump($affectedRows);

        // On retourne vrai, si au moins une ligne affectées
        // Si j'ai affecté plus d'une ligne, je retourne true
        // sinon je retourne false
        // Je m'assure que ma requête a modifié au moins une ligne 
        // dans la table label
        return ($affectedRows > 0);
    }

    /**
     * Méthode permettant de retourner un tableau d'objets LabelModel
     * représentant toutes les lignes de la table label
     * 
     * @return LabelModel[]
     */
    public function findAll() {
        // Parfois, si le nom d'un champ ou d'une table correspond à un mot clé
        // réservé de SQL, on peut avoir une erreur
        // Pour éviter çà, on peut utiliser le caractère ` pour entourer le nom
        // des tables et des champs
        $sql = "
            SELECT `id`, `name`, `created_at` AS `createdAt`, `updated_at` AS `updatedAt`
            FROM `label`
        ";

        // Ici, pas de risque d'injection SQL, car aucune donnée dynamique
        // dans ma requête, je peux donc utiliser query()
        $pdoStatement = Database::getPDO()->query($sql);

        // On récupère les résultats
        // Cela nous génère un tableau d'objet CardModel
        // Ici, on précise le FQCN (chemin complet de la classe)
        // car PDO va utiliser ce chemin dans sa classe à lui
        // qui dépend de la racine (car la classe PDO n'a pas de namespace)
        // Si on ne précise pas le chemin complet, et qu'on essaye de mettre
        // uniquement LabelModel, PDO irait chercher la classe LabelModel
        // à la racine '\' et ne la trouvera pas car elle se trouve
        // dans \Okanban\Models

        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, '\Okanban\Models\LabelModel');

        return $results;
    }

}
