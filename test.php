<?php
$zip = new ZipArchive(); 

if($zip->open('fichier.zip', ZipArchive::CREATE) === true){
  echo '&quot;Zip.zip&quot; ouvert<br/>';
  
  // Ajout d'un fichier
  $zip->addFile('media/camera.png',"camera.png");
  
  // Ajout d'un fichier
  $zip->addFile('media/film.png','film.png');
  
      // Et on referme l'archive
  $zip->close();
    echo 'Archive terminée<br/>';
  
	

        $file = $_SERVER["DOCUMENT_ROOT"]."/transfer-system/fichier.zip";
          echo $file;
        if (file_exists($file)) {
            // header('Content-Description: File Transfer');
            // header('Content-Type: application/octet-stream');

            header('Content-Disposition: attachment; filename='.basename($file));
            header('Content-Transfer-Encoding: binary');
            header('Content-Length: ' . filesize($file));

            // header('Expires: 0');
            // header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            // header('Pragma: public');
           
            // ob_clean();
            // flush();
            readfile($file);
            // unlink(fichier.zip);
            exit;
        }
  
}else{
  echo 'Impossible d&#039;ouvrir &quot;Zip.zip<br/>';
}

?>