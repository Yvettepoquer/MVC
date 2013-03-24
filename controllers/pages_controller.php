<?php
class PagesController extends Controller{

	function view($id = null, $slug){
		
		$id = (int) $id;
		// pr($slug);
		//On test si un paramètre éxiste
		if(!isset($id)){ $this->e404('La page demandée n\'éxiste pas.'); }
		
		else if( !$id ){ $this->e404('La page demandée n\'éxiste pas.'); }
		
		//On charge le modèle Post
		$this->loadModel('Post');
		
		$page = $this->Post->findFirst( array( 'conditions' => array( 'id' => $id, 'type' => 1, 'online' => 1) ) );
		if($slug != $page['slug']){
			$this->redirect('pages/view/id:'.$page['id'].'/slug:'.$page['slug'], 301);
		}
		//On test si la page demandée éxiste
		if(empty($page)){ $this->e404('La page demandée n\'éxiste pas.'); }
		
		// $this->getMenu();
		
		//On envoi les variables à la vue
		$this->set('page', $page);
			
		//pr($this->Post->findCount());
		
		//pr($post);
		
		//pr($this->Post->table_list());

		//pr($this->Post->query("SELECT * FROM posts", true));
	}
	
/**
* Cette fonction permet de renvoyer la totalité des pages trouvées dans la DB
*/	
	function getMenu(){
		
		$this->loadModel('Post');
		
		$allPages = $this->Post->find( array( 'conditions' => array( 'type' => 1, 'online' => 1) ) );
		
		return $allPages;
	}
}