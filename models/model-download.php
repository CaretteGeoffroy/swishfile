<?php

require_once('vendor/autoload.php');
require_once('models/connect-bdd.php');



function insertReceiverDownload($receiver) {

	global $bdd;

	$sql = "INSERT INTO `user_download`(`mail_receiver`) 
			VALUES (:receiver)";

	// Prépare la requête pour éviter les injections SQL...
	$response = $bdd->prepare( $sql );		

	// Bind les paramètres dans la requêtes...
	$response->bindParam(':receiver', $receiver, PDO::PARAM_STR);

	// Exécute la requête...
    $response->execute();
}




?>