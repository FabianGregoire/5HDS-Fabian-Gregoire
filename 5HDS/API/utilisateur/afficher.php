<?php

// HEADERS
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// INCLUSIONS
include_once '../config/Database.class.php';
include_once '../modeles/Utilisateur.class.php';

// BASE DE DONNÉES
$oDatabase = new Database();
$oBDD = $oDatabase->getConnexion();

// CRÉATION D'UN UTILISATEUR
$oUtilisateur = new Utilisateur($oBDD);


// query users
$stmt = $oUtilisateur->displayAll();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){

    // users array
    $users_arr = array();
    $users_arr["Utilisateurs"] = array();

    // retrieve our table contents
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $users_item=array(
            "token" => $token,
            "nom" => $nom,
            "prenom" => $prenom,
            "role" => $role,
            "created_at" => $created_at,
            "update_at" => $update_at,
        );

        array_push($users_arr["Utilisateurs"], $users_item);
    }

    // set response code - 200 OK
    http_response_code(200);

    // show products data in json format
    echo json_encode($users_arr);
}
// no products found will be here
else{
    // set response code - 404 Not found
    http_response_code(404);

    // tell the user no products found
    echo json_encode(
        array("message" => "No products found.")
    );
}
