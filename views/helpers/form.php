<?php
class form {

public $escpapeAttributes = array('type', 'value', 'displayError', 'label', 'div');
/**
*Cette fonction va créer le formulaire avec les options indiquées
*
*@param array $options Tableau des options possibles
*@return varchar Chaine de caractères contenant la balise de début du formulaire
*@access public
*/
	public function create($params){
		
		$htmlCode = '<form ';
		foreach($params as $k=>$v){
			$htmlCode .= $k.'="'.$v.'" ';//Parcours des options
		}	
		$htmlCode .= '>';
		return $htmlCode;
	}
	
	public function end($full = false, $titre = 'Envoyer'){
		$htmlCode = '';
		if($full){
			$htmlCode .= '<button type="submit" ><span>'.$titre.'</span></button><br/>';
		}
		$htmlCode .= '</form>';
		return $htmlCode;
	}
	
/**
*Cette fonction permet la création des champs input
*- type : Type de champ input --> hidden, text, textarea, checkbox, radio, file, password
*- label : Si vrai la valeur retournée conttiendra le champ label
*- div : Si vrai la valeur retournée sera insérée dans une div
*- displayError : si vrai affiche les erreurs sous les champs input
*- value : Si renseignée cette valeur sera insérée dans le champ input
*- tooltip : Si renseignée affichera un tooltip à côté du label
*- wysiwyg : Si renseignée et valeur à vrai alors le code de l'éditeur sera généré
*
*@param varchar $name Nom du champ input
*@param varchar $label Label pour le champ input
*@param array $options Options par défaut
*@return varchar Chaine html
*@access public
*
*/
	public function input($name, $label, $options = array()){
	
		//Liste des options par défaut
		$defaultOptions = array(
			'type' => 'text',
			'label' => true,
			'value' => false
		);
		
		//Je merge les deux tableaux, les indexs présents dans les deux tableaux recevront les valeurs des indexs du deuxieme tableau.
		$options = array_merge($defaultOptions, $options);//Génération du tableau d'options
		
		//Je teste si un label existe dans le tableau
		if($options['label']) {
			$label = '<label for="'.$options['id'].'">'.$options['label'].'</label>';//Si c'est le cas je le stocke dans une variable appellée $label.
		}
		
		//Préparation des attributs
		$attributes = ''; //Variable qui contiendra les différents attributs après vérification de ceux ci, par défaut elle est vide
		foreach($options as $k => $v) { //Parcours de l'ensemble des options
			
			//On filtre les attributs grâce à la variable de classe 'escapeAtttibutes' définie en début de fichier
			if(!in_array($k, $this->escapeAttributes)) { $attributes .= ' '.$k.'="'.$v.'"'; }  
		}
		
		//Je teste si les indexs 'id' et 'value' sont présent dans le tableau d'options
		//Si c'est le cas je les stocke dans des variables(pus rapide à utiliser)
		if(isset($options['id'])){ $inputId = $options['id']; } else { $inputId = '';}
		
		if(isset($options['value'])){ $inputValue = $options['value']; } else {$inputValue = '';}
		
		
		////////////////////////////////////////////////////////////////////////////
		///Génération du code HTML de retour en fonction des différents cas pssibles
		//On teste les différents cas possible pour le type 
		switch ($options['type']) {
			//Cas d'un input caché
			case 'hidden':
				$htmlCode = '<input type="hidden" id="'.$inputId.'" name="'.$name.'" value="'.$inputValue.'" />';
				break;
			//Cas d'un input de type texte
			case 'text':
				$htmlCode = '<input type="text" id="'.$inputId.'" name="'.$name.'" value="'.$inputValue.'"'.$attributes.' />';
				break;
			//Cas d'un input de type textarea
			case 'textarea':
				$htmlCode = '<input type="textarea" id="'.$inputId.'" name="'.$name.'"'.$attributes.' >'.$inputValue.'</textarea>';
				break;
			//Cas d'un input password
			case 'password':
				$htmlCode = '<input type="password" id="'.$inputId.'" name="'.$name.'" value="'.$inputValue.'"'.$attributes.' />';
				break;
			//Cas d'un inputi de type submit
			case 'submit':
				$htmlCode = '<input type="submit" id="'.$inputId.'" name="'.$name.'" value="'.$inputValue.'"'.$attributes.' />';
				break;
			//Cas d'un input de type button
			case 'button':
				$htmlCode = '<input type="button" id="'.$inputId.'" name="'.$name.'" value="'.$inputValue.'"'.$attributes.' />';
				break;
			//Cas d'un input de type select
			case 'select':
				$htmlCode = '<select id="'.$inputId.'" name="'.$name.'"'.$attributes.' >';
				foreach($options['selectOptions'] as $k => $v){
					$htmlCode .= '<option value="'.$k.'">'.$v.'</option>';
				}
				$htmlCode .= '</select>';
				break;
		}
		
		//Si un label existe je le retourne concaténé avec le code html de l'input.
		if($label){
			return $label.$htmlCode;
		}else{
		//Sinon je ne retourne que le code html de l'input...
			return $htmlCode;
		}
		
		// nom id affichage des input 
		// au niveau des att ne pas tout mettre
		
		// $htmlCode = '<input type="'.$type.'" name="'.$name.'" />';
	}
}
?>