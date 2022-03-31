<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/Database.class.php';
include_once '../modeles/Utilisateur.class.php';

// BASE DE DONNÉES
$oDatabase = new Database();
$oBDD = $oDatabase->getConnexion();

// CRÉATION D'UN UTILISATEUR
$oUtilisateur = new Utilisateur($oBDD);

if(
    isset($_GET['role']) &&
    isset($_GET['nom']) &&
    isset($_GET['prenom'])
) {

    $thisToken = randomToken(10);
    $oUtilisateur->role = $_GET['role'];
    $oUtilisateur->nom = $_GET['nom'];
    $oUtilisateur->prenom = $_GET['prenom'];
    $oUtilisateur->token = $thisToken;
    $oUtilisateur->created_at = date("Y-m-d H:i:s");
    $oUtilisateur->update_at = date("Y-m-d H:i:s");

    if($oUtilisateur->ajouter()){
        http_response_code(201);

        echo json_encode(array("message" => "Utilisateur créé, token : " . $thisToken));
    }
    else{
        http_response_code(503);

        echo json_encode(array("message" => "Impossible de créer l'utilisateur!"));
    }

}
else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
    echo json_encode(array("message" => "Unable to create the user. Data is incomplete and/or wrong."));
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
