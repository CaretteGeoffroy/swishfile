<?php


$file = "http://localhost/img/poum.png";
  
        // Define headers
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$file");
        header("Content-Type: application/png");
        header("Content-Transfer-Encoding: binary");
        
        // Read the file
        readfile($file);