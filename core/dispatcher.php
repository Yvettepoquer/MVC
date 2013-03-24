<?php
/**
* Cette classe est chargée d'effectuer les opérations suivantes : 
* - Instancier un objet de type Request qui va récupérer l'url
* - Parser cette url via l'objet Router
* - Charger le controller souhaité
*/
class Dispatcher{

	var $request;
	
	function __construct(){
		
		//On créer l'objet Request que l'on affecte à $this->request
		$this->request = new Request();
		
		//On parse l'url via l'objet Router
		Router::parse($this->request->url, $this->request);
		
		$controller = $this->loadController();
		// pr(get_class_methods($controller));
		// pr(get_class_methods('Controller'));
		$action = $this->request->action;
		if(isset($this->request->prefix)){
			$action = $this->request->prefix.'_'.$action;
		}
		$methods = get_class_methods('Controller');
		$methods2 = get_class_methods($controller);
		$retour = array_diff($methods2, $methods);
		
		if(!in_array($action, $retour)){
			$this->error("Le contrôleur ".$this->request->controller." n'a pas de méthode ".$this->request->action);
		}
		
		
		//Nous allons faire un appel dynamique à une fonction se trouvant dans un controlleur
		call_user_func_array(
			array(
				$controller,
				$action
			),
			$this->request->params //Paramètres éventuels
		);
		// pr($this->request);
		//On fait le rendu de la vue
		$controller->render($action);
		
		//pr($controller);
	}
	
	// mise en place d'une fonction pour gérer les erreurs de pages 
	function error($message){
	
		header("HTTP/1.0 404 Not Found");
		$controller = new Controller($this->request);
		$controller->set('message', $message);
		$controller->render('/errors/404');
		die();
	}
	
	
	/**
	* Cette fonction va charger un controller
	* @return $name Objet correspondant au type de controller souhaité
	*/
	function loadController(){
		
		//Nous allons récupérer le controleur directement avec la variable request, ucfirst -> Met le premier caractère en majuscule
		$name = ucfirst($this->request->controller).'Controller'; 
		
		$file = ROOT.DS.'controllers'.DS.$this->request->controller.'_controller.php';
		
		//Si le controller n'existe pas dans ce cas je lui indique une erreur 404 grâce à la fonction error. 
		if(!file_exists($file)){
			$this->error("Le controleur ".$this->request->controller." n'existe pas !");
		}
		require_once $file;
		$controller = new $name($this->request);
		$form = new Form();
		$controller->Form = $form;
		
		/** creation d'un objet dynamique portant le nom du controlleur**/
		return $controller;
	}
}	

