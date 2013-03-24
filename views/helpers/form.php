<?php
class form {

public $escpapeAttributes = array('type', 'value', 'displayError', 'label', 'div');
/**
*Cette fonction va cr�er le formulaire avec les options indiqu�es
*
*@param array $options Tableau des options possibles
*@return varchar Chaine de caract�res contenant la balise de d�but du formulaire
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
*Cette fonction permet la cr�ation des champs input
*- type : Type de champ input --> hidden, text, textarea, checkbox, radio, file, password
*- label : Si vrai la valeur retourn�e conttiendra le champ label
*- div : Si vrai la valeur retourn�e sera ins�r�e dans une div
*- displayError : si vrai affiche les erreurs sous les champs input
*- value : Si renseign�e cette valeur sera ins�r�e dans le champ input
*- tooltip : Si renseign�e affichera un tooltip � c�t� du label
*- wysiwyg : Si renseign�e et valeur � vrai alors le code de l'�diteur sera g�n�r�
*
*@param varchar $name Nom du champ input
*@param varchar $label Label pour le champ input
*@param array $options Options par d�faut
*@return varchar Chaine html
*@access public
*
*/
	public function input($name, $label, $options = array()){
	
		//Liste des options par d�faut
		$defaultOptions = array(
			'type' => 'text',
			'label' => true,
			'value' => false
		);
		
		//Je merge les deux tableaux, les indexs pr�sents dans les deux tableaux recevront les valeurs des indexs du deuxieme tableau.
		$options = array_merge($defaultOptions, $options);//G�n�ration du tableau d'options
		
		//Je teste si un label existe dans le tableau
		if($options['label']) {
			$label = '<label for="'.$options['id'].'">'.$options['label'].'</label>';//Si c'est le cas je le stocke dans une variable appell�e $label.
		}
		
		//Pr�paration des attributs
		$attributes = ''; //Variable qui contiendra les diff�rents attributs apr�s v�rification de ceux ci, par d�faut elle est vide
		foreach($options as $k => $v) { //Parcours de l'ensemble des options
			
			//On filtre les attributs gr�ce � la variable de classe 'escapeAtttibutes' d�finie en d�but de fichier
			if(!in_array($k, $this->escapeAttributes)) { $attributes .= ' '.$k.'="'.$v.'"'; }  
		}
		
		//Je teste si les indexs 'id' et 'value' sont pr�sent dans le tableau d'options
		//Si c'est le cas je les stocke dans des variables(pus rapide � utiliser)
		if(isset($options['id'])){ $inputId = $options['id']; } else { $inputId = '';}
		
		if(isset($options['value'])){ $inputValue = $options['value']; } else {$inputValue = '';}
		
		
		////////////////////////////////////////////////////////////////////////////
		///G�n�ration du code HTML de retour en fonction des diff�rents cas pssibles
		//On teste les diff�rents cas possible pour le type 
		switch ($options['type']) {
			//Cas d'un input cach�
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
		
		//Si un label existe je le retourne concat�n� avec le code html de l'input.
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