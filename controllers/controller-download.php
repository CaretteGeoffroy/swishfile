<?php
require_once('vendor/autoload.php');
require_once('models/model-download.php');

$loader = new Twig_Loader_Filesystem('views');
$twig = new Twig_Environment($loader);

