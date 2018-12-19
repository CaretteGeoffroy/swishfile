<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once('vendor/autoload.php');
require_once('models/model-file.php');

// TWIG LOADER
$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader);

global $action, $idFolder, $idFile;

switch ($action) {
	case 'upload':
		upload(); // UPLOAD UN FICHIER
		break;
	case 'download':
		download($idFolder, $idFile); // DOWNLOAD UN FICHIER
		break;
	case 'zip':
		download_zip($idFolder); // DOWNLOAD UN FICHIER ZIP
		break;
	default:
		echo $twig->render("file/index.twig"); 
		break;
}

// ACTION UPLOAD FILE
function upload() {
	
	global $twig;
	
	// CONFIG
	$extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' , 'txt' , 'doc' ); // Extensions autorisées.

	// Si on reçoit le formulaire...
	if (isset($_POST["submit"])) {

		// Mail de l'envoyeur :
		$senderMail = $_POST["sender-mail"];

		// Tableau mail des receveurs :
		$receiverMail = $_POST["receiver-mail"];

		// l.173 : Verifications des champs via Regex
		if (checkFormSend($senderMail, $receiverMail)) {
			// Message à l'UPLOAD
			$message = $_POST["message"];
			
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

					// Récupère le nombre de fichier contenu dans l'envois..
					$length = count($currentArrayNameFile);

					// MODELS :  Insert le mail de l'envoyeur et le message qu'il a écrit dans la table "user_upload"... 

					// Pour chaques fichiers temporaires...
					for($i = 0; $i < $length; $i++) {

						// Créer un nom unique pour un fichier...
						$nameFile = md5(uniqid(rand(), true)). "." .$extension_upload[$i]; 

						// Réassemble la chaine (nom du fichier) avec le nom unique du FICHIER et prépare le chemin de destination du fichier
						$path = "cloud/{$uniqueFolderName}/".$nameFile;

						// Déplace le FICHIER dans le DOSSIER
						$resultat = move_uploaded_file($currentArrayTempNameFile[$i],$path); 

						// Si le fichier est correctement déplacer...
						// if ($resultat) echo "Transfert réussi";
						// Pour chaques fichiers , crée un tableau avec toute les infos...
						$arrayFileInfos = array('name' =>   $currentArrayNameFile[$i],
										   		'size' =>   $currentArraySizeFile[$i],
										        'ext'  =>   $currentArrayTypeFile[$i],
										        'folder_key'  =>   $uniqueFolderName,
										        'file_key' => $nameFile
						);
						
						// MODELS :  Insert les infos de CHAQUES FICHIER dans la table files.. 
						insertFileUpload($arrayFileInfos);
						
					}

					// Prépare l'URL de téléchargement...
					$urlForDownload = makeUrlForDownload($uniqueFolderName);

					// Renseigne la table user_upload
					insertSenderUpload($senderMail, $message);

					// l. 119 : ENVOIS DU/DES MAILS avec l'URL...
					sendMailTo($senderMail, $receiverMail, $urlForDownload, $message); 

					echo $twig->render("file/upload.html.twig", array('url' => $urlForDownload)); // RENDER DE LA PAGE UPLOAD.

				} else {

					// MESSAGE ERREUR / EXT  : Extension non-autorisée
				}
			} else {

				// MESSAGE ERREUR / MAXSIZE : Taille maximal dépassée
			}
		} else {

			// MESSAGE ERREUR / REGEX : Erreur dans la saisi d'un champ
		}
	}

	}


// ACTION : DOWNLOAD FILE
function  download($idFolder, $idFile) {

	file_list($idFolder);
	download_file($idFolder, $idFile);
	// download_zip();

}

function download_zip($idFolder) {
	global $idFolder, $d, $file;

	$rep = $_SERVER["DOCUMENT_ROOT"]."/transfer-system/cloud/$idFolder";//Adresse du dossier
	$d = basename($rep,$_SERVER["DOCUMENT_ROOT"].'/transfer-system/cloud/');
	$path = "/transfer-system/file/download/$d";
	
	
	$zip = new ZipArchive(); 
	if($zip->open('swish.zip', ZipArchive::CREATE) === true){
	  	echo '&quot;Zip.zip&quot; ouvert<br/>';
	  	if($dossier = opendir($rep)){ 
		while( ($fichier = readdir($dossier)) !== false){ 
			if($fichier != '.' && $fichier != '..' ){ 
					$name = $fichier;
				$test = "$rep/$name";
			 // Ajout d'un fichier
			  $zip->addFile($test,$name);	
			} 
		} 
		closedir($dossier); 
	}else{
		echo 'Une erreur est survenue'; 
	}
			 // On referme l'archive
	$zip->close();
	echo 'Archive terminée<br/>';
	$file = $_SERVER["DOCUMENT_ROOT"]."/transfer-system/swish.zip";
	down($file);
	}else{
	  echo 'Impossible d&#039;ouvrir &quot;Zip.zip<br/>';
	}
}


function file_list($idFolder){
	global $twig, $idFile, $url_zip,$name;	

	$rep = $_SERVER["DOCUMENT_ROOT"]."/transfer-system/cloud/$idFolder";//Adresse du dossier
	$d = basename($rep,$_SERVER["DOCUMENT_ROOT"].'/transfer-system/cloud/');
	$path = "/transfer-system/file/download/$d";
	
	if($dossier = opendir($rep)){ 
		while( ($fichier = readdir($dossier)) !== false){ 
			if($fichier != '.' && $fichier != '..' ){ 
				
				$name = implode(getFile_name($fichier));

				$array_path[] = $path; 
				$array_fichier[] = $fichier; 
				$array_name[] = $name; 
			} 
		} 
		closedir($dossier); 
		$url_zip = "/transfer-system/file/zip/$idFolder";
		echo $twig->render('file/download.html.twig', array("array_path" => $array_path,
													   "array_fichier" => $array_fichier,
													   "array_name" => $array_name,"url_zip"=>$url_zip));

	}else{
		echo 'Une erreur est survenue'; 
	}
}


function download_file($idFolder, $idFile){
	global $file, $name;
	
	$file = $_SERVER["DOCUMENT_ROOT"]."/transfer-system/cloud/$idFolder/$idFile";

	down($file);
} 

// Calcul la taille total de tout les fichiers...
function getTotalSize($array) {
	$total = 0;
	foreach ($array as $size) {
		$total+= $size;
	}
	return $total;
}

	// Fonction gérant l'envois des mails...
function sendMailTo($sender, $receivers, $url, $message) {
		
	global $twig;

	$mail = new PHPMailer(true); 

	try {

	    //Server settings
	    // $mail->SMTPDebug = 2;                                 
	    $mail->isSMTP();                                      
	    $mail->Host = 'smtp.gmail.com';  					  
	    $mail->SMTPAuth = true;  
	    $mail->CharSet = 'UTF-8';   
	    $mail->Encoding = 'base64';                          
	    $mail->Username = 'swishfile.acs@gmail.com';          
	    $mail->Password = 'online@2017';                      
	    $mail->SMTPSecure = 'tls';                            
	    $mail->Port = 587;                                    

	    //Recipients  
	    $mail->setFrom('swishfile.acs@gmail.com');

	    // Pour chaques destinataire
	    foreach ($receivers as $receiver) {
	    	// N'ajoute pas les champs destinaire vide...
			if ($receiver != "") {
				// Ajoute un destinataire...
	    		$mail->addAddress($receiver);    
			}
	    }

	    //Content
	    $mail->isHTML(true);                                        
	    $mail->Subject = 'Une personne vous a envoyé des fichiers';
	    $mail->Body    = $twig->render('mail.twig',array("url" => $url, "sender" => $sender, "message" => $message));
	 	
	 	
	 	$mail->send();	
	 	
	    
	    // echo "Message envoyé !";

	} catch (Exception $e) {
    	echo "ERREUR ! Le message n'a pas été envoyé : ", $mail->ErrorInfo;
	}
		
}


// Vérifier la saisi des champs..
function checkFormSend($senderMail, $receiverMail) {
	// Regex traitant le champ email 
	$regMail =  "/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,})+$/i";

	// Initialisation des tests...
	$senderIsCheck = false;
	$receiversIsCheck = false;

	// Test sur l'unique champ envoyeur
	if (preg_match($regMail, $senderMail)) {
		$senderIsCheck = true;
	} else {
		$senderIsCheck = false;
	}

	// Parcours toute les email saisi dans les champs et teste les..
	foreach ($receiverMail as $mail) {
		// Vérifie que le champ ne soit pas vide...
		if ($mail != "") {
			// Mail par mail , on les passes sous la Regex...
			if (preg_match($regMail, $mail) != 1) {
				$receiversIsCheck = false;
				break;
			} else {
				$receiversIsCheck = true;
			}
		}
	}

	// Si tout est bon return true... Sinon false..
	if ($senderIsCheck && $receiversIsCheck) {
		return true;
	} else {
		return false;
	}

}

/* Récupère l'URL actuel,
supprime le controller home,
ajoute le controller file + l'action download,
réassemble en ajoutant la clée du dossier */
function makeUrlForDownload($key) {
	
	// AJUSTER POUR Compatibilité (TODO)
	$download_link = "transfer-system/file/download/". $key;

	return $download_link;
}

function down($file){
	global $file, $name;

	if (file_exists($file)) {
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.$name);
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . filesize($file));
		ob_clean();
		flush();
		readfile($file);
		unlink($file);
		exit;
	}
}
?>