<?php

//défini le contenu renvoyé comme json
header("Content-Type: application/json; charset=UTF-8");

// required headers pour la réception du body
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: *");
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];
if ($method == "OPTIONS") {
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
    header("HTTP/1.1 200 OK");
    die();
}

//division de l'url démandé
$parts = explode("/", $_SERVER["REQUEST_URI"]);

//ouverture de la base de données
$database = new Database($DB_HOST, $DB_PORT, $DB_DATABASE, $DB_USER, $DB_PASSWORD);

//gestion des redirections

if ($parts[1] == "api") {
    if ($parts[2] == "getmessage") {
        include("Api_component/getmessage.php");
    }
}
