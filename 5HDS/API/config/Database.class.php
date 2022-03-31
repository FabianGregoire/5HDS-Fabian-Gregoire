<?php

class Database {
    private $sHost = "localhost";
    private $sDBName = "api_5HDS_gestion_stock";
    private $sUsername = "root";
    private $sPassWord = "";
    public $connexion;

    public function getConnexion(){
        $this->connexion = null;

        try{
            $this->connexion = new PDO("mysql:host=". $this->sHost .";dbname=". $this->sDBName, $this->sUsername, $this->sPassWord);
            $this->connexion->exec("set names utf8");
        }
        catch (PDOException $oPDOException){
            echo "Erreur de connexion : " . $oPDOException->getMessage();
        }

        return $this->connexion;
    }
}