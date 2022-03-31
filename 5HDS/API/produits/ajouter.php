<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/Database.class.php';
include_once '../modeles/Produit.class.php';

// BASE DE DONNÉES
$oDatabase = new Database();
$oBDD = $oDatabase->getConnexion();

// CRÉATION D'UN PRODUIT
$oProduit = new Produit($oBDD);

if(
    isset($_GET['nom']) &&
    isset($_GET['reference']) &&
    isset($_GET['prix']) &&
    isset($_GET['description']) &&
    isset($_GET['stock'])
) {

    $thisToken = randomToken(10);
    $oProduit->nom = $_GET['nom'];
    $oProduit->reference = $_GET['reference'];
    $oProduit->prix = $_GET['prix'];
    $oProduit->description = $_GET['description'];
    $oProduit->stock = $_GET['stock'];
    $oProduit->created_at = date("Y-m-d");
    $oProduit->update_at = date("Y-m-d");
    $oProduit->token = $thisToken;

    if($oProduit->ajouter()){
        http_response_code(201);

        echo json_encode(array("message" => "Produit créé"));
    }
    else{
        http_response_code(503);

        echo json_encode(array("message" => "Impossible de créer le produit!"));
    }

}
else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
    echo json_encode(array("message" => "Unable to create product. Data is incomplete."));
}

function randomToken($car) {
    $string = "";
    $chaine =
        "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqr
stuvwxyz";
    srand ( ( double ) microtime () * 1000000 );
    for($i = 0; $i < $car; $i ++) {
        $string .= $chaine [rand () % strlen ( $chaine )];
    }
    return $string;
}