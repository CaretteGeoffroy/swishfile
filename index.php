<?php


if (isset($_SERVER["REQUEST_URI"])) {
	$requete = explode("/", trim($_SERVER['REQUEST_URI'], "/"));

	$controller = (count($requete) === 1)? "home":$requete[1];
	$action = (count($requete) < 3)? "log": $requete[2];
	$id = (count($requete) < 4)? 0 : $requete[3];
	$idDossier = (count($requete) < 5)? 0 : $requete[4];
	

	switch ($controller) {
		case 'file':
			require_once("controllers/controller-file.php");
			break;
		case 'admin':
			require_once("controllers/controller-dashboard.php");
			break;		
		default:
			require_once("controllers/404.twig");
			break;

	}
}

?>