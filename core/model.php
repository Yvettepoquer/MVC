<?php

class Model {
	
	public $conf = 'default';
	public $db;
	public $table = false;
	public $dbname;
	public $primaryKey = 'id';
	static $connections =array();
	
	
	public function __construct() {
		/** On charge le fichier database.php qui contient les paramètres pour se connecter à la base de donnée.**/ 
		require ROOT.DS.'configs'.DS.'database.php';
		$conf = $databases[$this->conf];
		$this->dbname = $conf['database'];
		// si le nom de la table n'est pas défini on va l'initialiser automatiquement
		// Par convention le nom de la table sera le nom de la classe en minuscule avec un s à la fin
		
		if($this->table === false){
		
			$tableName = strtolower(get_class($this)).'s'; // mise en variable du nom de la table
			$this->table = $tableName; //Affectation de la variable de classe
		}
		
		// on test qu'une connexion ne soit pas déjà active
		// Pour éviter de se connecter 2 fois à la base de données
		if(isset(Model::$connections[$this->conf])) { 
			$this->db = Model::$connections[$this->conf];
			return true;
		}
		
		// on va tenter de se connecter à la base de données
		
		try{
			//création d'un objet PDO
			$pdo = new PDO(
				'mysql:host='.$conf['host'].';dbname='.$conf['database'],
				$conf['login'],
				$conf['password'],
				array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')
				
			);
			
			// mise en place des erreurs de la classe PDO
			// Utilisation du mode exception pour récupérer les erreurs
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
			
			Model::$connections[$this->conf] = $pdo; // on affecte l'objet à la classe
			
			$this->db = $pdo;
			
			
		} catch(PDOException $e) { // erreur
			$message = '<pre style="background-color: #EBEBEB; border:1px dashed black; padding : 10px">';
			$message .= "La base de données n'est pas disponible merci de rééssayer plus tard ".$e->getMessage();
			$message .= '</pre>';
			die($message);
			
		}
		// echo 'je suis connecté à ma base de données';
		
	}
	
	
	/**
	 * Fonction permettant d'effectuer des recherches dans la base de données
	 * 
	 * $req peut être composé des index suivants :
	 * 	- fields (optionnel) : liste des champs à récupérer. Cet index peut être une chaine de caractères ou un tableau, si il est laissé vide la requête récupèrera l'ensemble des colonnes de la table.
	 * 	- conditions (optionnel) : ensemble des conditions de recherche à mettre en place. Cet index peut être une chaine de caractères ou un tableau.
	 * 	- moreConditions (optionnel) : cet index est une chaine de caractères et permet lorsqu'il est renseigné de rajouter des conditions de recherche particulières.
	 * 	- order (optionnel) : cet index est une chaine de caractères et permet lorsqu'il est renseigné d'effectuer un tri sur les éléments retournés.
	 * 	- limit (optionnel) : cet index est un entier et permet lorsqu'il est renseigné de limiter le nombre de résultats retournés.
	 *  - allLocales (optionnel) : cet index est un booléen qui permet lors de la récupération d'un élément d'indiquer si il faut ou non récupérer l'ensemble des champs traduits
	 * 
	 * @param 	array 	$req 	Tableau de conditions et paramétrages de la requete
	 * @param 	object 	$type 	Indique le type de retour de PDO dans notre cas un tableau dont les index sont les colonnes de la table
	 * @return 	array 	Tableau contenant les éléments récupérés lors de la requête  
	 * 
	**/
	
	public function find($req = array(), $type = PDO::FETCH_ASSOC) {
		
		$sql = 'SELECT ';
		
		// CHAMPS FIELDS //
		// si il 'y a pas de champs fields on va recup le shéma de la table 
		// Dans le cas de table traduite on va également récupérer les champs traduits
		if(!isset ($req['fields'])) {
			
			$req['fields'] = $this->shema();
			
		}
		if(is_array($req['fields'])){ $sql .= implode(', ', $req['fields']); 
		} else {
			$sql .= $req['fields']; // Si il s'agit d'une chaine de caractères
		}
		
		$sql .= ' FROM '.$this->table;
		$sql .= ' AS '.get_class($this).' ';
		
		// CHAMPS CONDITIONS //
		
		if(isset($req['conditions'])) {
		
			$cond = ' WHERE ';
			
			//On teste si $cond est un tableau
			//Sinon on est dans le cas d'une requête personnalisée
			if(!is_array($req['conditions'])){
			
				 $cond .= $req['conditions']; // on les ajoute à la requète
				
			} else {
				// $cond = array();
				$conditions_table = array();
				foreach ($req['conditions'] as $k => $v) {
				
					if(!is_numeric($v)){$v = $this->db->quote($v);} //Equivalent de mysql Escape string
						$conditions_table[] = get_class($this).'.'.$k.' = '.$v;
						// pr($conditions_table);					
				}
				$cond .= implode(' AND ', $conditions_table);//On rajoute les conditions à la requête
				// echo '</br>'.$cond;
				
			$sql .= $cond;
			}
			
			
		}
		
		if(isset($req['moreConditions']) && !empty($req['moreConditions'])){
			if(isset($req['conditions']) && !empty($req['conditions'])){
				$sql .= ' AND '.$req['moreConditions'];
			}else{$sql .= ' WHERE '.$req['moreConditions'];}
			
		}
		if(isset($req['order']) && !empty($req['order'])){
			$sql .= ' ORDER BY '.$req['order'];
		}
		if(isset($req['limit']) && !empty($req['limit'])){
			$sql .= ' LIMIT '.$req['limit'];
			// pr($sql);
		}
		$prepared_query = $this->db->prepare($sql); // On prépare la requête
		$result = $prepared_query->execute();
		// pr($sql);
		return $prepared_query->fetchall($type);
	}
		// pr($sql);
		
		
	/**
	*Fonction permettant de renvoyer le premier element d'un tableau.
	*
	*@param $req Tableau de conditions et paramétrages de la requete.
	*@return array Tableau contenant les données de l'élément
	*@access public
	*@use find
	*/
	public function findFirst($req){
		$request = $this->find($req);//On lance la requête
		return current($request);//Par défaut on va retourner le premier element du tableau	
	}
	
	/**
	*Fonction permettant de compter le nombre d'elements dans une table en fonction de parametres particuliers.
	*
	*@param 
	*@return array Tableau contenant les données de l'élément
	*@access public
	*@use find
	*/
	public function findCount($conditions = null, $moreConditions = null){
		$result = $this->findFirst(
			array(
				'fields' => "COUNT(".get_class($this).'.'.$this->primaryKey.") AS NbElements",
				'conditions' => $conditions,
				'moreConditions' => $moreConditions
			)
		
		);
		// $request = "SELECT COUNT(*) AS NbElements FROM posts";
		// return current($this->query($request, true));//Par défaut on va retourner le premier element du tableau	
		return $result['NbElements'];
	}
	
	
	/** 
	*	La fonction shema récupère le shema d'une table sql 
	*
	**/
	
	public function shema() {
		
		$tab= array();
		
		$sql = 'SHOW COLUMNS FROM '.$this->table;
	
		$result = $this->query($sql, true);
		foreach($result as $k => $v){
			
			 $tab[] = $v['Field'];
			
		}
		
		// pr($tab);
		// pr($result);
		return $tab;
	}
	
	
	public function table_list() {
		
		$tab= array();
		
		$sql = 'SHOW TABLES FROM '.$this->dbname;
	
		$result = $this->query($sql, true);
		foreach($result as $k => $v){
			
			 $tab[] = $v['Tables_in_mvc_bdd'];
			
		}
		
		//pr($tab);
		// pr($result);
		return $tab;
	}
	
	
	/**
	Cette fonction permet l'execution du requête sans passer par la fonction find
	Il suffit d'envoyer directement dans le paramètre $sql la requète à éffectuer (par exemple un SELECT ou autre)
	@param 		varchar 	$sql Requète à éffectuer
	@param 		booléan 	$return Indique si oui ou non on doit retourner le résultat de la requète
	@return 	array tableau contenant les éléments récupérées lors de la requete
	@access public 
	**/
	
	public function query($sql, $return = false) {
		
		$pre = $this->db->prepare($sql); // On prépare la requête
		$result = $pre->execute(); // On l'execute
		if($result) {
			// si l'execution s'est correctement déroulé 
			if($return) {return $pre->fetchall(PDO::FETCH_ASSOC);}
			// On retourne le résultat si demandé
			
			else {return true;} // On retourne vrai sinon
			
		} else { return false;} // si la requete ne s'est pas bien déroulé on retourne faux 
	}
	
	public function delete($id){
		if(is_array($id)){
			$idConditions = " IN (".implode(',', $id).')';}else{$idConditions = ' = '.$id; }	
		$sql = 'DELETE FROM '.$this->table.' WHERE '.$this->primaryKey.$idConditions.';';
		$result = $this->query($sql);
		return $result;
		
	}
	
	public function edit($id){
		
		// $sql = 'UPDATE '.$this->table.' SET '.$this->primaryKey.'='.$value;
	}
}