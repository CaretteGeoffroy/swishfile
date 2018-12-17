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
    global $id, $twig, $base_url;
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

    echo $twig->render('download.twig',array("base_url" => $base_url));
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

function download_zip(){

    $zip = new ZipArchive();
    if($zip->open("swish.zip", ZipArchive::CREATE)){

        $zip->addFile("img/1.jpg");
        $zip->addFile("img/2.jpg");
        $zip->close();
        // header('Content-Description: File Transfer');
        // header('Content-Type: application/octet-stream');
        // header('Content-Disposition: attachment; filename='.basename("swish.zip"));
        // // header('Content-Transfer-Encoding: binary');
        // header('Expires: 0');
        // header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        // header('Pragma: public');
        // header('Content-Length: ' . filesize("swish.zip"));
        // ob_clean();
        // flush();

        // readfile("swish.zip");




        $fichier = "swish.zip";
     
        // téléchargement du fichier 
        header('Content-disposition: attachment; filename='.$fichier); 
        header('Content-Type: application/x-zip'); 
        header('Content-Transfer-Encoding: Binary');  
        header('Content-Length: '.filesize($fichier)); 
        header('Pragma: no-cache'); 
        header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0'); 
        header('Expires: 0'); 
        readfile($fichier);
        exit;
    }

}
