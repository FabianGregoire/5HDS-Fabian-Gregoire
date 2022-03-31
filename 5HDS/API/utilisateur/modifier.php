<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../config/Database.class.php';
include_once '../modeles/Utilisateur.class.php';

// get database connection
$oDatabase = new Database();
$oBDD = $oDatabase->getConnexion();

// prepare user
$oUtilisateur = new Utilisateur($oBDD);

// set token of user to be edited
$oUtilisateur->token = $_GET['token'];

// set user property values
$oUtilisateur->role = $_GET['role'];
$oUtilisateur->nom = $_GET['nom'];
$oUtilisateur->prenom = $_GET['prenom'];
$oUtilisateur->update_at = date("Y-m-d H:i:s");

// update the user
if($oUtilisateur->modifier()){

    // set response code - 200 ok
    http_response_code(200);

    // tell the user
    echo json_encode(array("message" => "L'utilisateur a été mis à jour."));
}

// if unable to update the user, tell the user
else{

    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the user
    echo json_encode(array("message" => "Impossible de modifier cet utilisateur, vérifiez les champs remplis"));
}
