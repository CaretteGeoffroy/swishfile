<?php
require_once('vendor/autoload.php');
require_once('models/model-download.php');

$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader);

switch ($action) {
    
    case 'list':
        file_list();
        break;
    case 'file':
        download_file();
        break;
    case 'zip':
        download_zip();
        break;
    default:
        file_list();
        break;
}




function file_list(){
    global $id,$lien;
    $rep = $_SERVER["DOCUMENT_ROOT"]."/transfer-system/cloud/$id";//Adresse du dossier
    $path = "/transfer-system/download/file/$d";

    echo '<ul>'; 
    if($dossier = opendir($rep)){ 
        while( ($fichier = readdir($dossier)) !== false){ 
            if($fichier != '.' && $fichier != '..' ){ 

                $fileInfo = pathinfo($fichier);
                $lien = $fileInfo["filename"];
                $name = implode(getFile_name($lien));
                // echo $key;
                // echo $lien;
                echo '<li><a href="'.$path.'/'.$lien.'">'.$name.'</a></li>'; 
            } 
        } 
        echo '</ul><br/>'; 
        closedir($dossier); 
    }else{
        echo 'Une erreur est survenue'; 
    }
}


function download_file(){
    global $id, $file;



    $file = $_SERVER["DOCUMENT_ROOT"]."/transfer-system/cloud/$id'/'.$file";
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