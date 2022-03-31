<?php

class Produit {

    // Connexion BDD et nom de la table
    private $oConnexion;
    private $tableName = "produit";

    // Propriétés
    public $reference;
    public $nom;
    public $prix;
    public $description;
    public $token;
    public $stock;
    public $created_at;
    public $update_at;
    /**
     * Produit constructor.
     * @param $oBDD
     */
    public function __construct($oBDD) {
        $this->oConnexion = $oBDD;
    }

    /**
     * Ajouter un produit dans la BDD
     * @return bool
     */
    public function ajouter(){

        // query to insert record
        $sRequete = "INSERT INTO " . $this->tableName . "
            SET nom=:nom,
                reference=:reference,
                prix=:prix,
                description=:description,
                update_at=:update_at,
                stock=:stock,
                created_at=:created_at,
                token=:token";

        // prepare query
        $stmt = $this->oConnexion->prepare($sRequete);

        // bind values
        $stmt->bindParam(":nom", $this->nom);
        $stmt->bindParam(":reference", $this->reference);
        $stmt->bindParam(":prix", $this->prix);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":update_at", $this->update_at);
        $stmt->bindParam(":stock", $this->stock);
        $stmt->bindParam(":created_at", $this->created_at);
        $stmt->bindParam(":token", $this->token);

        // execute query
        if($stmt->execute()){
            return true;
        }
        print_r($stmt->errorInfo());
        return false;
    }


    /**
     * Modifier un produit dans la BDD
     * @return bool
     */
    public function modifier(){
        $sRequete2 = "UPDATE ". $this->tableName ."
            SET nom = :nom,
                reference = :reference,
                prix = :prix,
                description = :description,
                update_at = :update_at,
                stock = :stock,
            WHERE
                token = :token";

        // prepare query statement
        $stmt2 = $this->oConnexion->prepare($sRequete2);

        // bind new values
        $stmt2->bindParam(":nom", $this->nom);
        $stmt2->bindParam(":reference", $this->reference);
        $stmt2->bindParam(":prix", $this->prix);
        $stmt2->bindParam(":description", $this->description);
        $stmt2->bindParam(":update_at", $this->update_at);
        $stmt2->bindParam(":stock", $this->stock);
        $stmt2->bindParam(":token", $this->token);

        // execute the query
        if($stmt2->execute()){
            return true;
        }
        return false;
    }

    /**
     * Afficher tous les produits de la BDD
     * @return mixed
     */
    public function displayAll(){
        // select all query
        $sRequete = "SELECT * FROM ". $this->tableName;

        // prepare query statement
        $stmt = $this->oConnexion->prepare($sRequete);

        // execute query
        $stmt->execute();

        return $stmt;
    }


    /**
     * Supprimer un produit dans la BDD
     * @return bool
     */
    public function supprimer(){
        // delete query
        $query = "DELETE FROM " . $this->tableName . " WHERE token = :token";

        // prepare query
        $stmt = $this->oConnexion->prepare($query);

        // bind id of record to delete
        $stmt->bindParam(":token", $this->token);

        // execute query
        if($stmt->execute()){
            return true;
        }

        return false;
    }
}