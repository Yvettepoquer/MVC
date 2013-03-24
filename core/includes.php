<?php
require('session.php');
Session::init();
// Session::check('toto');
require('set.php');
if(Session::check('toto')){echo 'toto existe';}else{echo 'toto n\'existe pas...';}
// Session::setFlash('confirmation', 'success');
//pr($_SESSION);
// pr(Session::read('monIndex'));


require('router.php');
require('inflector.php');
require ROOT.DS.'views'.DS.'helpers'.DS.'form.php';
require ROOT.DS.'configs'.DS.'routes.php';
require('request.php');
require('controller.php');
require('model.php');
require('dispatcher.php');


function pr($mVar2Display) {
	
	// debug_backtrace — Génère le contexte de déboguage
	$debug = debug_backtrace();
	
	echo '<pre style="background-color: #EBEBEB; border: 1px dashed black; width: 100%; padding: 10px;">';
	print_r('<font color="green">[FICHIER] : '.$debug[0]['file']."</font>\n");
	print_r('<font color="brown">[LIGNE] : '.$debug[0]['line']."</font>\n\n");
	print_r('<font color="blue">[RÉSULTAT] : '."\n");
	print_r($mVar2Display);
	echo '</font></pre>';
}


