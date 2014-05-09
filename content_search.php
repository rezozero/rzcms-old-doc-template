<?php 

if (isset($_GET['q']) && $_GET['q'] != '') {
	$nodes = rz_node::get_rows(array('node_type'=>'pages','search'=>strip_tags($_GET['q'])));
}

 ?>
<h1 id="page_title"><?php echo(dgettext("template", "Search results")); ?></h1>
<ul class="content">
	<?php while ($node = rz_node::hydrate($nodes)) {
	?>
	<li class='result'>
		<h3><a href='<?php echo $node->get_node_url() ?>'><?php echo $node->title ?></a></h3>
		<article class='excerpt'><?php echo( substr(strip_tags(Markdown($node->content)), 0, 150).'[…]')?></article>
	</li>
	<?php
	} ?>

</ul>