<?php


if (isset($_SERVER["REQUEST_URI"])) {
	$requete = explode("/", trim($_SERVER['REQUEST_URI'], "/"));

	$controller = (count($requete) === 1)? "file":$requete[1];
	$action = (count($requete) < 3)? "": $requete[2];
	$id = (count($requete) < 4)? 0 : $requete[3];
	$idDossier = (count($requete) < 5)? 0 : $requete[4];
	

	switch ($controller) {
		case 'file':
		require_once("controllers/controller-file.php");
		break;
		case 'dashboard':
			require_once("controllers/controller-dashboard.php");
			break;		
		default:
			echo "404";
			break;
	}
}

?>