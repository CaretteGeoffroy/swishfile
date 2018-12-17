<?php
require_once('vendor/autoload.php');
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

function bdd_($id = 0, $order) {
    global $bdd;

    $request = 
    
 
    $response = $bdd->prepare( $request );
    $response->bindParam(':id', $id, PDO::PARAM_INT);
    $response->execute();
    return $response->fetchAll(PDO::FETCH_ASSOC);
}
?>