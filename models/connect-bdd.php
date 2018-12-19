<?php 

    // Fichier pour se connecter à la base de donnée.
    
	$username = 'valerieh';
	$password = 'hWz96+tt9yPcqA==';
	$database ='valerieh_TRANSFER_DB';
	$host = 'localhost';

    try{

        $bdd = new PDO('mysql:host='.$host.';dbname='.$database.';charset=utf8',$username , $password);

    }catch (Exception $e){

        die('Erreur : ' . $e->getMessage());

    }

?>
