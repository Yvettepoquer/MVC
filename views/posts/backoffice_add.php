<?php 
if(Session::read('flash')){ 
	$flashMessage = Session::read('flash');?>
	<p class="<?php echo $flashMessage['type']; ?>"><?php echo $flashMessage['message']; ?> </p> 
<?php
	Session::delete('flash');
	unset($flashMessage);
	} ?>
<h1>Ajouter un article</h1>
<?php 
	echo $this->Form->create(array('method' => 'POST', 'action' => Router::url('/adm/posts/add'))); echo '<br/>';
	echo $this->Form->input('name', "Titre de l'article"); echo '<br/>';
	echo $this->Form->input('slug', "Url"); echo '<br/>';
	echo $this->Form->input('content', "Contenu", array('type' => 'textarea')); echo '<br/>';
	echo $this->Form->input('online', "En ligne", array('type' => 'checkbox')); echo '<br/>';
	echo $this->Form->end(true);
?>
	
	