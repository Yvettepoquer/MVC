<?php
////////////////////////////////////////////////////////////
//   DEFINITION DES VARIABLES GLOBALES DE L'APPLICATION   //
////////////////////////////////////////////////////////////

define('DS', DIRECTORY_SEPARATOR); //Définition du séparateur dans le cas ou l'on est sur windows ou linux
define('WEBROOT', dirname(__FILE__)); //Chemin absolu vers le dossier webroot
define('ROOT', dirname(WEBROOT)); //Chemin absolu vers le dossier racine du site
define('CORE', ROOT.DS.'core'); //Chemin relatif vers le coeur de l'application
define('BASE_URL', dirname(dirname($_SERVER['SCRIPT_NAME']))); //
define('CSS', BASE_URL.'/webroot/css/');
define('JS', BASE_URL.'/webroot/js/');
define('IMG', BASE_URL.'/webroot/img/');

require(CORE.DS.'includes.php'); //test
$dispatcher = new Dispatcher();

