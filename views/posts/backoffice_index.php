<h1>Liste des articles</h1>
<?php 
	// echo 'Fonction Backoffice_index';
	// pr($posts);
	?>
	<table>
	
	<thead>
		<tr>
		   <th><input class="check-all" type="checkbox" /></th>
		   <th>Id</th>
		   <th>Titre</th>
		   <th>Contenu</th>
		   <th>Editer</th>
		   <th>Supprimer</th>
		</tr>
		
	</thead>
	<tfoot>
		<tr>
			<td colspan="6">
				<div class="bulk-actions align-left">
					<select name="dropdown">
						<option value="option1">Choisir une action...</option>
						<option value="option2">Editer</option>
						<option value="option3">Supprimer</option>
					</select>
					<a class="button" href="#">Appliquer à la séléction</a>
				</div>
				
				<div class="pagination">
					<a href="#" title="First Page">&laquo; First</a><a href="#" title="Previous Page">&laquo; Previous</a>
					<a href="#" class="number" title="1">1</a>
					<a href="#" class="number" title="2">2</a>
					<a href="#" class="number current" title="3">3</a>
					<a href="#" class="number" title="4">4</a>
					<a href="#" title="Next Page">Next &raquo;</a><a href="#" title="Last Page">Last &raquo;</a>
				</div> <!-- End .pagination -->
				<div class="clear"></div>
			</td>
		</tr>
	</tfoot>
	<tbody>
	<?php
	foreach($posts as $post){
		?>
		<tr>
			<td align="center" width="50px"><input type="checkbox" /></td>
			<td align="center" width="50px"><?php echo $post['id']?></td>
			<td align="center" width="150px"><?php echo $post['name']?></td>
			<td align="center" width="150px"><?php echo substr($post['content'],0,100).'...';?></td>
			
			<td align="center" width="50px"><a href="edit/<?php echo $post['id']; ?>" title="Modifier"><img src="http://cdn1.iconfinder.com/data/icons/CrystalClear/16x16/mimetypes/txt2.png"/></a></td>
			<td align="center" width="50px"><a href="delete/<?php echo $post['id']; ?>" title="Supprimer"><img src="http://cdn1.iconfinder.com/data/icons/fugue/icon/cross.png"/></a></td>
		</tr>
		<?php
	}
	if(Session::read('flash')){ 
		$flashMessage = Session::read('flash');?>
		<p class="<?php echo $flashMessage['type']; ?>"><?php echo $flashMessage['message']; ?> </p> 
	<?php
		Session::delete('flash');
		unset($flashMessage);
	} ?>
	</tbody>
	</table>