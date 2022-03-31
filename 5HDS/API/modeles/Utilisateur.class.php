<?php

class Utilisateur {

    // Connexion BDD et nom de la table
    private $oConnexion;
    private $tableName = "users";

    public $role;
    public $token;
    public $prenom;
    public $nom;
    public $created_at;
    public $update_at;


    /**
     * Utilisateur constructor.
     * @param $oBDD
     */
    public function __construct($oBDD) {
        $this->oConnexion = $oBDD;
    }

    /**
     * Afficher tous les utilisateurs de la BDD
     * @return mixed
     */
    public function displayAll() {
        // select all query
        $sRequete = "SELECT * FROM " . $this->tableName;

        // prepare query statement
        $stmt = $this->oConnexion->prepare($sRequete);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    /**
     * Ajouter un utilisateur dans la BDD
     * @return bool
     */
    public function ajouter() {

        // query to insert record
        $sRequete = "INSERT INTO " . $this->tableName . "
            SET role = :role, 
                token = :token, 
                prenom = :prenom,
                nom = :nom, 
                created_at = :created_at, 
                update_at = :update_at";

        // prepare query
        $stmt = $this->oConnexion->prepare($sRequete);

        // bind values
        $stmt->bindParam(":role", $this->role);
        $stmt->bindParam(":token", $this->token);
        $stmt->bindParam(":prenom", $this->prenom);
        $stmt->bindParam(":nom", $this->nom);
        $stmt->bindParam(":created_at", $this->created_at);
        $stmt->bindParam(":update_at", $this->update_at);

        // execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }


    /**
     * Modifier un utilisateur dans la BDD
     * @return bool
     */
    public function modifier() {

        $sRequete = "UPDATE " . $this->tableName . "
            SET role = :role,
                update_at = :update_at,
                prenom = :prenom,
                nom = :nom
            WHERE
                token = :token";

        // prepare query statement
        $stmt = $this->oConnexion->prepare($sRequete);

        // bind new values
        $stmt->bindParam(":update_at", $this->update_at);
        $stmt->bindParam(":role", $this->role);
        $stmt->bindParam(":prenom", $this->prenom);
        $stmt->bindParam(":nom", $this->nom);
        $stmt->bindParam(":token", $this->token);

        // execute the query
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }


    /**
     * Supprimer un utilisateur dans la BDD
     * @return bool
     */
    public function supprimer() {
        // delete query
        $query = "DELETE FROM " . $this->tableName . " WHERE token = :token";

        // prepare query
        $stmt = $this->oConnexion->prepare($query);

        // bind id of record to delete
        $stmt->bindParam(":token", $this->token);

        // execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

}
