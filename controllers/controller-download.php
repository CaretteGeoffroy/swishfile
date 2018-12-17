<?php
require_once('vendor/autoload.php');

$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader);

switch ($action) {
    case 'show':
       show();
        break;
    case 'download':
        download();
        break;
    case 'folder':
        folder();
        break;
    default:
        show();
        break;
}

function show(){
    global $twig;
    echo $twig->render("download.twig");
}


function folder(){
    global $id;
    $rep = $_SERVER["DOCUMENT_ROOT"]."/transfer-system/cloud/$id";//Adresse du dossier
    $path = "/transfer-system/file/download";
    echo '<ul>'; 
    if($dossier = opendir($rep)){ 
        while( ($fichier = readdir($dossier)) !== false){ 
            if($fichier != '.' && $fichier != '..' ){ 
                // $fileInfo = pathinfo($fichier);
                echo '<li><a href="' . $path . '/' .$fichier. '">' . $fichier . '</a></li>'; 
            } 
        } 
        echo '</ul><br/>'; 
        closedir($dossier); 
    }else{
        echo 'Une erreur est survenue'; 
    }
}


function download(){
    global $id;


    // $lien = $fileInfo["filename"];

    // $file_key = getKey($lien);

    $file = $_SERVER["DOCUMENT_ROOT"]."/transfer-system/cloud/$id";
      echo $file;
    if (file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.basename($file));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        ob_clean();
        flush();
        readfile($file);
        exit;
    }
} 

// $file = "http://localhost/img/1.jpg";
    
// // Define headers
// header("Cache-Control: public");
// header("Content-Description: File Transfer");
// header("Content-Disposition: attachment; filename=$file");
// header("Content-Type: application/png");
// header("Content-Transfer-Encoding: binary");

// // Read the file
// readfile($file);