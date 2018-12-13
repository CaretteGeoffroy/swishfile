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
    global $id;
    $rep = $_SERVER["DOCUMENT_ROOT"]."/transfer-system/cloud/$id";//Adresse du dossier
    $d = basename($rep,$_SERVER["DOCUMENT_ROOT"].'/transfer-system/cloud/');

    $path = "/transfer-system/download/file/$d";
    echo '<ul>'; 
    
    if($dossier = opendir($rep)){ 
        while( ($fichier = readdir($dossier)) !== false){ 
            if($fichier != '.' && $fichier != '..' ){ 
                $name = implode(getFile_name($fichier));
                echo '<li><a href="'.$path.'/'.$fichier.'">'.$name.'</a></li>'; 
            } 
        } 
        echo '</ul><br/>'; 
        closedir($dossier); 
    }else{
        echo 'Une erreur est survenue'; 
    }
}


function download_file(){
    global $id,$file;

    $file = $_SERVER["DOCUMENT_ROOT"]."/transfer-system/cloud/$id/$file";
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

function download_zip() {

    $dossier = "./cloud/566642055c125ea005c911.86065219";

    $zip = new ZipArchive();
    $filename = "test112.zip";

    if ($zip->open($filename, ZipArchive::CREATE)!==TRUE) {
        exit("Impossible d'ouvrir le fichier <$filename>\n");
    } else {
        if($dossier = opendir($dossier)){ 
            while( ($fichier = readdir($dossier)) !== false){ 
                if($fichier != '.' && $fichier != '..' ){
                    $zip->addFile(realpath($fichier)); 
                }        
            }       
        }

        closedir($dossier);
    }
    
    $zip->close();

}