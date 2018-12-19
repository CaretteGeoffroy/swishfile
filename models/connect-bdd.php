<?php 

    // Fichier pour se connecter à la base de donnée.
    
	$username = 'geoffroyc';
	$password = 'u33b07ptwRLtrA==';
	$database ='geoffroyc_transfer_bdd';
	$host = 'localhost';

    try{

        $bdd = new PDO('mysql:host='.$host.';dbname='.$database.';charset=utf8',$username , $password);

    }catch (Exception $e){

        die('Erreur : ' . $e->getMessage());

    }

?>
