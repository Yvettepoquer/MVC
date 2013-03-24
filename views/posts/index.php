<?php
$title_for_layout = 'Liste des articles';
$description_for_layout = 'Liste des articles';
?>
<div>
	 <h1>Liste des articles</h1>
	<?php
		// echo $page['content'];
		// pr($allPosts);
		?>
		<ul>
		<?php
		foreach($posts as $k=>$v){
			
			echo '<li><a href="'.Router::url('posts/view/id:'.$v['id'].'/slug:'.$v['slug'].'/prefix:article').'" title="'.$v['name'].'">'.$v['name'].'</a></li>';
			echo '<li style="list-style-type:none">'.$v['content'].'</li>';
		}
		?>
		</ul>
</div>
<div class="pagination">
	<style> 
		.pagination li{list-stype-type:none; float:left; color:green; padding:3px; height:20px; border-radius:3px; background:lightgrey; display:block; margin-left:5px;}
		.pagination li:hover{background:grey; color:white;}
		.pagination li a{color:green; text-decoration:none;}
		.pagination li a:hover{color:white;}
		
	</style>
	<ul>
		<li><a href="<?php echo Router::url('posts/index'); ?>?page=1">First</a></li>
		<?php for($i=1; $i<=$nbPages; $i++){ ?>
			<li><a href="<?php echo Router::url('posts/index'); ?>?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
		<?php } ?>
		<li><a href="<?php echo Router::url('posts/index'); ?>?page=<?php echo $nbPages; ?>">last</a></li>
	</ul>
</div>
