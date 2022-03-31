<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../config/Database.class.php';
include_once '../modeles/Produit.class.php';

// get database connection
$oDatabase = new Database();
$oBDD = $oDatabase->getConnexion();

// prepare product object
$oProduit = new Produit($oBDD);

// set ID property of product to be edited
$oProduit->token = $_GET['token'];

// set product property values
$oProduit->nom = $_GET['nom'];
$oProduit->reference = $_GET['reference'];
$oProduit->prix = $_GET['prix'];
$oProduit->description = $_GET['description'];
$oProduit->update_at = date("Y-m-d");
$oProduit->stock = $_GET['stock'];

// update the product
if($oProduit->modifier()){

    // set response code - 200 ok
    http_response_code(200);

    // tell the user
    echo json_encode(array("message" => "Le produit a été mis à jour."));
}

// if unable to update the product, tell the user
else{

    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the user
    echo json_encode(array("message" => "Impossible de modifier ce produit"));
}