<?php
/**
* Cette classe va faire les actions suivantes : 
* - Récupération de l'url courante
* - Gestion des variables passées en GET
* - Gestion des variables passées en POST
* - Gestion des champs upload
* - __construct() : PHP permet aux développeurs de déclarer des constructeurs pour les classes. Les classes qui possèdent une méthode constructeur appellent cette méthode à chaque création d'une 		nouvelle instance de l'objet, ce qui est intéressant pour toutes les initialisations dont l'objet a besoin avant d'être utilisé. 
*/
class Request{

	public $url;
	public $page;
	public $datas = false;
	
	function __construct(){
		
		$this->url = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/'; //Affectation de l'url
		if (isset($_GET['page']) && !empty($_GET['page'])){
			$this->page = $_GET['page'];
		}else{$this->page = 1;}
		if(!empty($_POST)){
			if(!$this->datas){ $this->datas = array();}
			//On test si la variable $_POST n'est pas vide
			foreach($_POST as $k=>$v){//On foreach cette variable
				if(!is_array($v)){$v = stripsplashes($v);}
				$this->datas[$k] = $v;//Et on affecte chaque clée à chaque valeur dans la variable $datas de la classe...
			}
		}
	}
}	

