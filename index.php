<?php

// require_once("models/connect_bdd.php");
// require_once("models/film_model.php");

	if (isset($_SERVER["REQUEST_URI"])) {

		$requete = explode("/", trim($_SERVER['REQUEST_URI'], "/"));
		// print_r($requete);
		// echo count($requete);
		$controller = (count($requete) === 1)? "home":$requete[1];
		$action = (count($requete) < 3)? "log": $requete[2];
		// $id = (count($requete) < 4)? 0 : intval($requete[3]);

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
			default:
				require_once("views/404.twig");
				break;

		}
	}


?>