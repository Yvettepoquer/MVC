<?php
class Controller{
	
	public $request;
	public $layout = 'default';
	
	private $vars = array();
	private $rendered = false;
	
	function __construct($request = NULL){
		if(isset($request)){
			$this->request = $request;
		}
	}

/**
* Fonction permettant l'ppel d'un emethode d'un controlleur depuis un vue
*
* @param $controller
* @param $action Etant l'action 
*/
	function requestAction($controller, $action){
	
		$name = ucfirst($controller).'Controller'; 
		$file = ROOT.DS.'controllers'.DS.$controller.'_controller.php';
		// if(!file_exists($file)){
			// $this->error("Le contrôleur ".$this->request->controller." n'existe pas !");
		// }
		require_once $file;
		
		/** creation d'un objet dynamique portant le nom du controlleur**/
		$object =  new $name();
		return $object->$action();
	}
/**
* Cette fonction permet de rendre une vue
*/
	function render($view){
		
		if($this->rendered) {return false;}
		
		//On extrait les variable en fonctions des clées du tableau passées en paramètre
		extract($this->vars);
		if(strpos($view, '/') ===0) {$view = ROOT.DS.'views'.$view.'.php';}
		else {$view = ROOT.DS.'views'.DS.$this->request->controller.DS.$view.'.php';}
		
		//On démarre la temporisation de sortie (buffer)
		ob_start();
		require($view);
		//On vide le buffer dans une variable
		$content_for_layout = ob_get_clean();
		// pr($this->request);
		if(isset($this->request->prefix)){$this->layout = $this->request->prefix;}
		//On charge un layout par défault
		require(ROOT.DS.'views'.DS.'layout'.DS.$this->layout.'.php');
		$this->rendered=true;
	}
	
/**
* Accesseur en écriture
* Permet d'envoyer une variable à la vue
*
* @param mixed $key Nom de la variable ou tableau de variables
* @param varchar $value Valeur de la variable il est optionnel
* @access public
* @author Bob
* @version 1.0
* exemple: $this->set('variable', $variable); ou $this->set(array('key1'=>$value1, 'key2'=>$value2, 'key3'=>$value3));
*/
	public function set($key, $value = null){
	
		if(is_array($key)){ $this->vars += $key; }
		else{ $this->vars{$key} = $value; }
	}
	
/** Fonction public loadModel 
* $modelName 
*
*
**/
	public function loadModel($modelName){
	
		$file = ROOT.DS.'models'.DS.lcfirst($modelName).'.php';
		require_once($file);
		/** la dernière ligne évite de charger plusieurs fois le même model **/
		if(!isset($this->$modelName)){ $this->$modelName = new $modelName(); }
		
	}
	
	
	
	function redirect($url, $codeErreur = null){
	// Codes de redirection possibles
	$http_codes = array(
			100 => 'Continue',
			101 => 'Switching Protocols',
			200 => 'OK',
			201 => 'Created',
			202 => 'Accepted',
			203 => 'Non-Authoritative Information',
			204 => 'No Content',
			205 => 'Reset Content',
			206 => 'Partial Content',
			300 => 'Multiple Choices',
			301 => 'Moved Permanently',
			302 => 'Found',
			303 => 'See Other',
			304 => 'Not Modified',
			305 => 'Use Proxy',
			307 => 'Temporary Redirect',
			400 => 'Bad Request',
			401 => 'Unauthorized',
			402 => 'Payment Required',
			403 => 'Forbidden',
			404 => 'Not Found',
			405 => 'Method Not Allowed',
			406 => 'Not Acceptable',
			407 => 'Proxy Authentication Required',
			408 => 'Request Time-out',
			409 => 'Conflict',
			410 => 'Gone',
			411 => 'Length Required',
			412 => 'Precondition Failed',
			413 => 'Request Entity Too Large',
			414 => 'Request-URI Too Large',
			415 => 'Unsupported Media Type',
			416 => 'Requested range not satisfiable',
			417 => 'Expectation Failed',
			500 => 'Internal Server Error',
			501 => 'Not Implemented',
			502 => 'Bad Gateway',
			503 => 'Service Unavailable',
			504 => 'Gateway Time-out'
	);
		
		//Je teste s'il existe un code erreur
		if(isset($codeErreur)) { 
			header("HTTP/1.0 ".$codeErreur." ".$http_codes[$codeErreur]); //Si c'est le cas je le renseigne dans le header...
		}
		//Je formate l'url
		$url = Router::url($url);
		//Je redirige vers l'url formatée
		header("Location: ".$url);
		die; //Pour éviter que les fonctions ne continuent
	}
/*
*Fonction permettant d'afficher la page 404 si une erreur est renvoyée
*
*
*
*/
	public function e404($message){
		header("HTTP/1.0 404 Not Found");
		$this->set('message', $message);
		$this->render('/errors/404');
		die();
		
	}
}