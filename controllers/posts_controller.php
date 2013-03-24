<?php
class PostsController extends Controller{
	function view($id = null, $slug){
		
		$id = (int) $id;
		
		
		//On test si un paramètre éxiste
		if(!isset($id)){ $this->e404('La page demandée n\'éxiste pas.'); }
		
		else if( !$id ){ $this->e404('La page demandée n\'éxiste pas.'); }
		
		//On charge le modèle Post
		$this->loadModel('Post');
		
		$post = $this->Post->findFirst( array( 'conditions' => array( 'id' => $id, 'type' => 2, 'online' => 1) ) );
		
		
		//On test si la page demandée éxiste
		if(empty($post)){ $this->e404('La page demandée n\'éxiste pas.'); }
		
		if($slug != $post['slug']){
			$this->redirect('posts/view/id:'.$post['id'].'/slug:'.$post['slug'].'/prefix:article', 301);
		}
		
		//On envoi les variables à la vue
		$this->set('post', $post);
			
		//pr($this->Post->findCount());
		
		//pr($post);
		
		//pr($this->Post->table_list());

		//pr($this->Post->query("SELECT * FROM posts", true));
	}
	function index(){
		//J'affiche deux elements par page...
		$d['elementsPerPage'] = 2;
		//Je teste si la variable GET existe
		// if (isset ($_GET['page']) && !empty($_GET['page'])){
			//Je l'affecte au tableau
		$d['page'] = $this->request->page;
		//Sinon elle vaut 1
		// }else $d['page'] = 1;
		$limit = $d['elementsPerPage']*($d['page']-1);
		
		$this->loadModel('Post');
		$conditions = array( 'type' => 2, 'online' => 1);
		$d['posts'] = $this->Post->find( array( 'conditions' => $conditions, 'limit' => $limit.', '.$d['elementsPerPage'] ) );
		$d['nbPosts'] = $this->Post->findCount( $conditions );
		$d['nbPages'] = ceil($d['nbPosts'] / $d['elementsPerPage']);
		$this->set($d);
		
		
	}
	
	function backoffice_index(){
		$this->loadModel('Post');
		$conditions = array('type' => '2');
		$posts = $this->Post->find( array( 'conditions' => $conditions ));
		$this->set('posts', $posts);
	}
	
	function backoffice_delete($id){
		$id = (int) $id;
		$this->loadModel('Post');
		if(!isset($id) && !$id){//On teste si l'id éxiste et si c'est un entier...
			Session::flash('Impossible de supprimer l\'élement', 'error');
		}
		if($this->Post->delete($id)){
			Session::setFlash('L\'élément a été supprimé avec succes');
		}else{
			Session::setFlash('Impossible de supprimer l\'élément', 'error');
		}
		$this->redirect('adm/posts/index');
	}
	
	function backoffice_edit($id){
		$id = (int) $id;
		//On test si un paramètre éxiste
		if(!isset($id)){ $this->e404('La page demandée n\'éxiste pas.'); }
		else if( !$id ){ $this->e404('La page demandée n\'éxiste pas.'); }
		$this->loadModel('Post');
		$this->Post->edit($id);
		// $this->redirect('adm/posts/index');
	}
	
	function backoffice_add(){
		
	}
}	
?>