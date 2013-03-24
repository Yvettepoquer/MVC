<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="fr">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php if(isset($title_for_layout) && !empty($title_for_layout)) { ?><title><?php echo $title_for_layout; ?></title><?php } ?>
<?php if(isset($description_for_layout) && !empty($description_for_layout)) { ?><meta name="description" content="<?php echo $description_for_layout; ?>"/><?php } else { ?> <meta name="description" content="Page d'accueil de mon site"/> <?php } ?>
<style>
	.menu li{ float:left; width:100px; list-style-type:none; background:grey; border-radius:5px; border: 1px solid black; text-align:center; margin-right:2px;margin-bottom:2px;}
	.menu li a{color:white; text-decoration:none; line-height:25px;}
	li:hover{background:lightgrey;}
</style>
</head>
<body>
	<div class="menu">
		<ul>
		<li><a href="<?php echo Router::url('posts/index'); ?>" title="Blog">Blog</a></li>
		<?php
		$allPages = $this->requestAction('pages', 'getMenu');
		foreach ($allPages as $k => $v){
		?>
			<li><a href="<?php echo Router::url('pages/view/id:'.$v['id'].'/slug:'.$v['slug']) ;?> "> 
			<?php echo $v['name'] ?></a></li><?php
		}
		?>	
		</ul>
		
	</div></br></br>
	<?php echo $content_for_layout; ?>
</body>
</html>