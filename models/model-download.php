<?php

require_once('vendor/autoload.php');
require_once('models/connect-bdd.php');



function getFile_name($fichier) {

    global $bdd;

    $requete = $bdd->prepare('SELECT files.file_name FROM files WHERE files.file_key = :fichier');
    $requete->bindValue(':fichier', $fichier, PDO::PARAM_STR);
    $data = $requete->execute();
    $resultat = $requete->fetch(PDO::FETCH_ASSOC);

    return $resultat;
}






?>