<?php
require_once('vendor/autoload.php');

// TWIG LOADER
$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader);
echo $twig->render("dashboard.twig"); // RENDER DE LA PAGE PRINCIPAL.