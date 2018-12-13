<?php

if (isset($_SERVER["REQUEST_URI"])) {
	$requete = explode("/", trim($_SERVER['REQUEST_URI'], "/"));

	$controller = (count($requete) === 1)? "home":$requete[1];
	$action = (count($requete) < 3)? "log": $requete[2];
	$id = (count($requete) < 4)? 0 : $requete[3];
	$file = (count($requete) < 5)? 0 : $requete[4];

	switch ($controller) {
		case 'home':
			require_once("controllers/controller-home.php");
			break;
		case 'admin':
			require_once("controllers/controller-admin.php");
			break;
		case 'dashboard':
			require_once("controllers/controller-dashboard.php");
			break;	
		case 'download':
			require_once("controllers/controller-download.php");
			break;			
		default:
			require_once("controllers/404.twig");
			break;
	}
}

?>