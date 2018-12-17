<?php
if (isset($_SERVER["REQUEST_URI"])) {
	$requete = explode("/", trim($_SERVER['REQUEST_URI'], "/"));
	$controller = (count($requete) === 1)? "file":$requete[1];
	$action = (count($requete) < 3)? "": $requete[2];
	$idFolder = (count($requete) < 4)? 0 : $requete[3];
	$idFile = (count($requete) < 5)? 0 : $requete[4];
	
	switch ($controller) {
		case 'dashboard':
			require_once("controllers/controller-dashboard.php");
			break;	
		case 'file':
			require_once("controllers/controller-file.php");
			break;
		default:
			echo "Error 404";
			break;
	}
}
?>