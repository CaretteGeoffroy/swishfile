<?php 


require_once('vendor/autoload.php');

// TWIG LOADER
$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader);
echo $twig->render("index.twig");

// CONFIG
$extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' );
$i = uniqid(rand(), true);

$mail = $_POST['mail'];
echo $mail;
if (isset($_POST["submit"])) {
	$maxSize = $_POST["MAX_FILE_SIZE"];
	if ($_FILES["up"]["size"] < $maxSize) {
		$extension_upload = strtolower(  substr(  strrchr($_FILES['up']['name'], '.')  ,1)  );
		if ( in_array($extension_upload,$extensions_valides) ) {
			echo "Extension correcte";	
			mkdir("cloud/{$i}/", 0777, true);
			$nom = md5(uniqid(rand(), true));
			$nom = "cloud/{$i}/".$nom.".".$extension_upload;
			echo $nom;
			$resultat = move_uploaded_file($_FILES['up']['tmp_name'],$nom);
			if ($resultat) echo "Transfert réussi";
		} 
	} 
}

?>