<?php 

    // Fichier pour se connecter à la base de donnée.
    
	$username = 'lucasr';
	$password = 'n2zs0Kx9/3281Q==';
	$database ='lucasr_TRANSFER_DB';
    $host = 'localhost';
    
    // $username = 'root';
	// $password = 'online@2017';
	// $database ='TRANSFER_DB';
	// $host = 'localhost';

    try{

        $bdd = new PDO('mysql:host='.$host.';dbname='.$database.';charset=utf8',$username , $password);

    }catch (Exception $e){

        die('Erreur : ' . $e->getMessage());

    }

?>
