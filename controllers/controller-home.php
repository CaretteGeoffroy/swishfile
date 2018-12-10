<?php 


require_once('vendor/autoload.php');

// TWIG LOADER
$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader);
echo $twig->render("index.twig"); // RENDER DE LA PAGE PRINCIPAL.

// CONFIG
$extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' ); // Extensions autorisées.

// Si on reçoit le formulaire...
if (isset($_POST["submit"])) {

	$uniqueFolderName = uniqid(rand(), true); // Génère un nom de DOSSIER unique à chaques UPLOAD.

	$currentArrayNameFile = $_FILES["up"]["name"]; 
	$currentArrayTypeFile = $_FILES["up"]["type"]; 
	$currentArrayTempNameFile = $_FILES["up"]["tmp_name"]; 
	$currentArrayErrorFile = $_FILES["up"]["error"]; 
	$currentArraySizeFile = $_FILES["up"]["size"];

	// Récupére la taille total des fichiers UPLOAD
	$totalSize = getTotalSize($currentArraySizeFile);
	
	// print_r($currentArrayNameFile);

	// Récupère la taille maximal autorisé reçu via l'input hidden...
	$maxSize = $_POST["MAX_FILE_SIZE"];

	// Si la taille du fichier est inférieur à la taille max autorisé...
	if ($totalSize < $maxSize) {

		foreach ($currentArrayNameFile as $element) {

			// Découpe le nom des fichiers pour récupérer leurs extensions...
			$extension_upload[] =  strtolower(  substr(  strrchr($element, '.')  ,1)  ); 
		}

		// Si les extensions récupérées sont contenues dans le tableau des extensions autorisées.
		if ( array_intersect($extension_upload,$extensions_valides) ) { 

			mkdir("cloud/{$uniqueFolderName}/", 0777, true); // Créer le DOSSIER unique à l'UPLOAD...

			for($i = 0; $i < count($currentArrayTempNameFile); $i++) {

				$nom = md5(uniqid(rand(), true)); // Créer un nom unique pour un fichier...
				// Réassemble la chaine (nom du fichier) avec le nom unique du FICHIER...
				$nom = "cloud/{$uniqueFolderName}/".$nom.".".$extension_upload[$i]; 

				// Déplace le FICHIER dans le DOSSIER
				$resultat = move_uploaded_file($element,$nom); 

				// Si le fichier est correctement déplacer...
				if ($resultat) echo "Transfert réussi";
			}
			
		} else {

			// MESSAGE / RENDER  : Extension non-autorisée
		}
	} 
}

function getTotalSize($array) {
	$total = 0;
	foreach ($array as $size) {
		$total+= $size;
	}
	return $total;
}


?>