<?php

require_once('vendor/autoload.php');
require_once('models/connect-bdd.php');



function getFile_name($lien) {

    global $bdd, $lien, $fileInfo;

    $requete = $bdd->prepare('SELECT files.file_name FROM files WHERE files.file_key = :lien');
    $requete->bindValue(':lien', $lien, PDO::PARAM_STR);
    $data = $requete->execute();
    $resultat = $requete->fetch(PDO::FETCH_ASSOC);

    return $resultat;
}






?>