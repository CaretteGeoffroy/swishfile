<?php
require_once('vendor/autoload.php');
require_once('models/model-admin.php');

// TWIG LOADER
$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader);
echo $twig->render("admin.twig"); // RENDER DE LA PAGE PRINCIPAL.



if(isset($_POST['inputName']) && isset($_POST['inputPassword'])){

    $user = $_POST["inputName"];
    $password = $_POST["inputPassword"];

    $login = getIdentifier($user, $password);
    
    print_r($login);


    
}








?>