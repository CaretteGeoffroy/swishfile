<?php
require_once('vendor/autoload.php');
require_once('models/connect-bdd.php');



function getIdentifier($user, $password) {

    global $bdd;

    $req = $bdd->prepare('SELECT * FROM admin WHERE admin.user = :admin AND admin.pass = :password'); // Je compte le nombre d'entrée ayant pour mot de passe et login ceux rentrés
    $req->bindValue(':password', $password, PDO::PARAM_STR);
    $req->bindValue(':admin', $user, PDO::PARAM_STR);
    $data = $req->execute();
    $res = $req->fetchAll(PDO::FETCH_ASSOC);

    return $res;
}

?>