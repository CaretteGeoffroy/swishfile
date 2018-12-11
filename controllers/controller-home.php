<?php 


require_once('vendor/autoload.php');
require_once('models/model-upload.php');

// TWIG LOADER
$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader);
echo $twig->render("index.twig"); // RENDER DE LA PAGE PRINCIPAL.

// CONFIG
$extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' ); // Extensions autorisées.

// Si on reçoit le formulaire...
if (isset($_POST["submit"])) {

	// Mail de l'envoyeur :
	$senderMail = $_POST["sender-mail"];

	// Tableau mail des receveurs :
	$receiverMail = $_POST["receiver-mail"];

	// Génère un nom de DOSSIER unique à chaques UPLOAD.
	$uniqueFolderName = uniqid(rand(), true); 

	// Tableaux qui contiennent les informations de chacun des fichiers uploadés...
	$currentArrayNameFile = $_FILES["up"]["name"]; // Tout les noms de chacuns des fichiers
	$currentArrayTypeFile = $_FILES["up"]["type"]; // Tout les types de chacun des fichiers
	$currentArrayTempNameFile = $_FILES["up"]["tmp_name"]; // Tout les fichiers temporaires
	$currentArrayErrorFile = $_FILES["up"]["error"]; // Tout les messages d'erreur de chacun des fichiers
	$currentArraySizeFile = $_FILES["up"]["size"]; // Tout les poids en Octet de chacun des fichiers

	// Récupére la taille total des fichiers UPLOAD
	$totalSize = getTotalSize($currentArraySizeFile);
	
	// print_r($currentArrayNameFile);

	// Récupère la taille maximal autorisé reçu via l'input hidden...
	$maxSize = $_POST["MAX_FILE_SIZE"];

	// Si la taille du fichier est inférieur à la taille max autorisé...
	if ($totalSize < $maxSize) {

		// Pour chacuns des noms de fichiers...
		foreach ($currentArrayNameFile as $element) {

			// Découpe le nom du fichier pour récupérer son extensions et ajoute le dans un array...
			$extension_upload[] =  strtolower(  substr(  strrchr($element, '.')  ,1)  ); 
		}

		// Si les extensions récupérées sont contenues dans le tableau des extensions autorisées.
		if ( array_intersect($extension_upload,$extensions_valides) ) {

			// Créer le DOSSIER unique à l'UPLOAD...
			mkdir("cloud/{$uniqueFolderName}/", 0777, true); 

			// Pour chaques fichiers temporaires...
			for($i = 0; $i < count($currentArrayTempNameFile); $i++) {

				// Créer un nom unique pour un fichier...
				$nom = md5(uniqid(rand(), true)); 

				// Réassemble la chaine (nom du fichier) avec le nom unique du FICHIER...
				$nom = "cloud/{$uniqueFolderName}/".$nom.".".$extension_upload[$i]; 

				// Déplace le FICHIER dans le DOSSIER
				$resultat = move_uploaded_file($currentArrayTempNameFile[$i],$nom); 

				// Si le fichier est correctement déplacer...
				// if ($resultat) echo "Transfert réussi";


				prepareDatasForInsert();
			
			}
			
		} else {

			// MESSAGE / RENDER  : Extension non-autorisée
		}
	} 
}

// Calcul la taille total de tout les fichiers...
function getTotalSize($array) {
	$total = 0;
	foreach ($array as $size) {
		$total+= $size;
	}
	return $total;
}

function prepareDatasForInsert() {

	
	insertFileToDb($arrayDatas);

}

?>