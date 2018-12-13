<?php

require_once('vendor/autoload.php');
require_once('models/connect-bdd.php');



function getKey($lien) {

    global $bdd, $lien, $fileInfo;

    $requete = $bdd->prepare('SELECT files.file_key AS key FROM files WHERE files.file_name = :lien');
    $requete->bindValue(':lien', $lien, PDO::PARAM_STR);
    $data = $requete->execute();
    $resultat = $requete->fetch(PDO::FETCH_ASSOC);

    return $resultat;
}



?>