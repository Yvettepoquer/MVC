<h1>Liste des articles</h1>
<?php 
	// echo 'Fonction Backoffice_index';
	// pr($posts);
	?>
	<table>
	<tr>
			<th>Id</th>
			<th>Name</th>
			<th>Editer</th>
			<th>Supprimer</th>
		</tr>
	<?php
	foreach($posts as $post){
		?>
		<tr>
			<td align="center" width="150px"><?php echo $post['id']?></td>
			<td align="center" width="150px"><?php echo $post['name']?></td>
			<td align="center" width="50px"><a href="edit/<?php echo $post['id']; ?>" title="Modifier"><img src="http://cdn1.iconfinder.com/data/icons/CrystalClear/16x16/mimetypes/txt2.png"/></a></td>
			<td align="center" width="50px"><a href="delete/<?php echo $post['id']; ?>" title="Supprimer"><img src="http://cdn1.iconfinder.com/data/icons/fugue/icon/cross.png"/></a></td>
		</tr>
		<?php
	}
	?>
	</table>