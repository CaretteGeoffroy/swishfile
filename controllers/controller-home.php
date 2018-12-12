<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once('vendor/autoload.php');
require_once('models/model-upload.php');
// require('vendor/phpmailer/phpmailer/src/Exception.php');
// require('vendor/phpmailer/phpmailer/src/PHPMailer.php');
// require('vendor/phpmailer/phpmailer/src/SMTP.php');

// TWIG LOADER
$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader);
echo $twig->render("index.twig"); // RENDER DE LA PAGE PRINCIPAL.

// CONFIG
$extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' , 'txt' , 'doc'); // Extensions autorisées.

// Si on reçoit le formulaire...
if (isset($_POST["submit"])) {

	// Mail de l'envoyeur :
	$senderMail = $_POST["sender-mail"];

	// Tableau mail des receveurs :
	$receiverMail = $_POST["receiver-mail"];

	// Message à l'UPLOAD
	// $message = $_POST["message"];

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

			// Récupère le nombre de fichier contenu dans l'envois..
			$length = count($currentArrayNameFile);

			// Insert le mail de l'envoyeur et le message qu'il a écrit dans la table "user_upload"...
			// insertSenderUpload($senderMail, $message);

			// Pour chaques fichiers temporaires...
			for($i = 0; $i < $length; $i++) {

				// Créer un nom unique pour un fichier...
				$nom = md5(uniqid(rand(), true)); 

				// Réassemble la chaine (nom du fichier) avec le nom unique du FICHIER...
				$nom = "cloud/{$uniqueFolderName}/".$nom.".".$extension_upload[$i]; 

				// Déplace le FICHIER dans le DOSSIER
				$resultat = move_uploaded_file($currentArrayTempNameFile[$i],$nom); 

				// Si le fichier est correctement déplacer...
				// if ($resultat) echo "Transfert réussi";
				// Pour chaques fichiers , crée un tableau avec toute les infos...
				$arrayFileInfos = array('name' =>   $currentArrayNameFile[$i],
								   		'size' =>   $currentArraySizeFile[$i],
								        'ext'  =>   $currentArrayTypeFile[$i],
								        'key'  =>   $uniqueFolderName
				);
				
				// Insert les infos de CHAQUES FICHIER dans la table files..
				insertFileUpload($arrayFileInfos);
				
			}

		} else {

			// MESSAGE / RENDER  : Extension non-autorisée
		}
		die;
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


function sendMail() {
	$mail = new PHPMailer(true); 
	try {
	    //Server settings
	    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
	    $mail->isSMTP();                                      // Set mailer to use SMTP
	    $mail->Host = 'smtp1.example.com;smtp2.example.com';  // Specify main and backup SMTP servers
	    $mail->SMTPAuth = true;                               // Enable SMTP authentication
	    $mail->Username = 'user@example.com';                 // SMTP username
	    $mail->Password = 'secret';                           // SMTP password
	    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
	    $mail->Port = 587;                                    // TCP port to connect to

	    //Recipients
	    $mail->setFrom('from@example.com', 'Mailer');
	    $mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
	    $mail->addAddress('ellen@example.com');               // Name is optional
	    $mail->addReplyTo('info@example.com', 'Information');
	    $mail->addCC('cc@example.com');
	    $mail->addBCC('bcc@example.com');

	    //Attachments
	    // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
	    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

	    //Content
	    $mail->isHTML(true);                                  // Set email format to HTML
	    $mail->Subject = 'Here is the subject';
	    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
	    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

	    $mail->send();
	    echo 'Message has been sent';
	} catch (Exception $e) {
    	echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
	}
	
}

?>