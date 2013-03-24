<?php
class Session{
/**
* Fonction pour l'initialisation des sessions...
*/
	static function init(){
		ini_set('session.use_trans_sid', 0);//Evite de passer l'id de la session dans l'url.
		session_name("MonMVC"); //On affecte le nom
		session_start(); //On démarr"e le session
		
	}
	
/**
* Fonction permettant de vérifier si un élément est présent dans la variable de session
*
*@param varchar $key
*/
	static function check($key){
		if(empty($key)){return false;}//Si laclé est vide j retourne faux
		$return = Set::classicExtract($_SESSION, $key);//On procède à l'extraction de la donnée
		return isset($return);//On retourne le resultat
		// if(isset($return)){return true;}else{return false;}
	}
	
/**
* Une fonction pour écrire une donnée dan la variable de session
*
*@ param $path
*/
	static function write($path, $value){
		$session = Set::insert($_SESSION, $path, $value);
		$_SESSION = $session;
		return Set::classicExtract($_SESSION, $path) == $value;
		// if(Set::classicExtract($_SESSION, $key) == $value){return true;}else{return true;}
	}
	
/**
* Une fonction pour litre la valeur d'un élément
*/
	static function read($path){
		$result = Set::classicExtract($_SESSION, $path);
		if(!is_null($result)){
			return $result;
		}else{
			return false;
		}
	}
/** 
* Une fonction permettant de supprimer un élément
*/
	static function delete($path){
		$session = Set::remove($_SESSION, $path);
		$_SESSION = $session;
		return (Session::check($path) == false);
	}
/**
* fonction permettant de détruire la variable de session
*/
	static function destroy(){
		session_unset();
		session_destroy();
	}

/**
* Une fonctio pour insérer un message flash	
*/
	static function setFlash($message, $type = 'success'){
		Session::write('flash.message', $message);
		Session::write('flash.type', $type);
		
	}
	
}
