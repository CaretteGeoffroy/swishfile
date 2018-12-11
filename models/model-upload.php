<?php 

require_once('models/connect-bdd.php');

function insertFileToDb($arrayDatas) {

	global $bdd;

	$sql = "INSERT INTO `files`(`file_url`, `file_name`, `file_size`, `file_ext`, `file_key`)
	 	VALUES (:url, :name, :size, :ext, :key, :message)
		INSERT INTO `user_upload`(`mail_sender`, `message`) 
		VALUES (:sender, :message)";

	// Prépare la requête pour éviter les injections SQL...
	$response = $bdd->prepare( $sql );

	// Bind les paramètres dans la requêtes...
	$response->bindParam(':size', $arrayDatas["size"], PDO::PARAM_STR);
	$response->bindParam(':url', $arrayDatas["url"], PDO::PARAM_STR);
	$response->bindParam(':name', $arrayDatas["name"], PDO::PARAM_STR);
	$response->bindParam(':ext', $arrayDatas["ext"], PDO::PARAM_STR);
	$response->bindParam(':key', $arrayDatas["key"], PDO::PARAM_STR);
	$response->bindParam(':message', $arrayDatas["message"], PDO::PARAM_STR);
	$response->bindParam(':sender', $arrayDatas["sender"], PDO::PARAM_STR);

	// Exécute la requête...
    $response->execute();
    
}


?>