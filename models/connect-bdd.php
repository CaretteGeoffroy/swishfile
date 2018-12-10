<?php 

    // Fichier pour se connecter à la base de donnée.
    
	$username = 'root';
	$password = 'online@2017';
	$database ='transfert_system';
	$host = 'localhost';

    try{

        $bdd = new PDO('mysql:host='.$host.';dbname='.$database.';charset=utf8',$username , $password);

    }catch (Exception $e){

        die('Erreur : ' . $e->getMessage());

    }

?>
