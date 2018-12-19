<?php
require_once('models/connect-bdd.php');


function getIdentifier($user, $password) {

    global $bdd;

    $req = $bdd->prepare('SELECT COUNT(id) AS nombre FROM admin WHERE admin.name = :admin AND admin.password = :password'); // Je compte le nombre d'entrée ayant pour mot de passe et login ceux rentrés
    $req->bindValue(':password', $password, PDO::PARAM_STR);
    $req->bindValue(':admin', $user, PDO::PARAM_STR);
    $data = $req->execute();
    $res = $req->fetch(PDO::FETCH_ASSOC);

    return $res;
}


// dashboard

// Un graphique Histogramme permettant de comparer le nombre de fichiers envoyés par jour 
// d'après le numéro de semaine choisie dans une liste déroulante de l'année un cours.   
// ex : Semaine 12 en 2018 - Lundi 12 fichiers, Mardi 14 fichier, Mercredi 52 fichiers...jusqu'au Dimanche.
function histogramme() {

    global $bdd;

    $sql = "SELECT (SELECT WEEK(ADDDATE(upload_date,5-DAYOFWEEK(upload_date)),3)) as week, 
    DAYNAME(upload_date) as day, 
    COUNT(*) FROM `user_upload`
    WHERE (SELECT WEEK(ADDDATE(upload_date,5-DAYOFWEEK(upload_date)),3)) = $week
    Group by week, day";
   
// Prépare la requête pour éviter les injections SQL...
$response = $bdd->prepare( $sql );

// Bind les paramètres dans la requêtes...
$response->bindParam(':week', $arrayDatas["week"], PDO::PARAM_STR);
$response->bindValue(':day', $arrayDatas["day"], PDO::PARAM_STR);
$response->bindParam(':count', $arrayDatas["count"], PDO::PARAM_STR);

// Exécute la requête...
$response->execute();
}







?>