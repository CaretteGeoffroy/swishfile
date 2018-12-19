<?php

require_once('vendor/autoload.php');
require_once('models/model-dashboard.php');

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

        echo $twig->render("dashboard/admin.twig", array("error"=>"invalid"));
    }else{
        echo $twig->render("dashboard/admin.twig");
    }
}

function verif(){
    global $twig;
    
    if(isset($_POST['inputName']) && isset($_POST['inputPassword'])){
    
        $user = $_POST["inputName"];
        $password = $_POST["inputPassword"];
    
        $login = getIdentifier($user, $password);
        
        // var_dump($login["nombre"]);
            if($login["nombre"]==="1"){
    
                session_start();
                $_SESSION['user'] = $user;
                $_SESSION['pwd'] = $password;
            //    header('location:/transfer-system/dashboard');
               echo $twig->render("dashboard/dashboard.twig");

            
            }else{
                header('location:/transfer-system/dashboard/error');
            }
    }
}

// Dashboard
function showHistogramme() {
    global $twig, $id;
    if ($id !=0) {
        $details = bdd_actDetail($id);
    } elseif ($id < 1 || $id > 52) {
        $details = bdd_actDetail(1);
    }
    echo $twig->render('dashboard.twig', array('' => $details, "base_url" => $base_url));
}
switch ($action) {
    case 'list':
    histogramme();
        break;

    // case 'detail':
    //     actDetail();
    //     break;

    //     default:
	// 	echo $twig->render(".twig"); 
	// 	break;
}

?>
