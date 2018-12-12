<?php

require_once('vendor/autoload.php');
require_once('models/model-admin.php');

// TWIG LOADER
$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader);
 // RENDER DE LA PAGE PRINCIPAL.

switch ($action) {
    case 'log':
    case 'error':
       showlog();
        break;
    case 'verif':
        verif();
         break;
    default:
        # code...
        break;
}

function showlog(){
    global $twig,$action;
    if($action==="error"){

        echo $twig->render("admin.twig", array("error"=>"invalid"));
    }else{
        echo $twig->render("admin.twig");
    }
}


function verif(){

    if(isset($_POST['inputName']) && isset($_POST['inputPassword'])){
    
        $user = $_POST["inputName"];
        $password = $_POST["inputPassword"];
    
        $login = getIdentifier($user, $password);
        
        var_dump($login["nombre"]);
            if($login["nombre"]==="1"){
    
                session_start();
                $_SESSION['user'] = $user;
                $_SESSION['pwd'] = $password;
               header('location:/transfer-system/dashboard');
            
            }else{
                header('location:/transfer-system/admin/error');
            }
    }
}


?>
