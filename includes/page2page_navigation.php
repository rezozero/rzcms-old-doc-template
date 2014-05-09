<?php 
$columns = array(
	'node_id',
 	'node_name',
 	'parent_node_id',
 	'node_type_id',
 	'url_token'
);


$parentNodeNav = $this->getRequestedNode()->get_parent();
$hasChildren = $this->getRequestedNode()->has_children();

/*
 * Searching previous readable node
 */
$previousPage = $this->getRequestedNode()->get_previous();
if (!is_object($previousPage)) {
	$previousPage = $parentNodeNav;

	$parentPrevNode = $previousPage->get_previous();
	$parentParentNode = $previousPage->get_parent();
	if ($previousPage->get_node_type()->name != 'pages' && is_object($parentPrevNode)) 
	{
		$previousPages = $parentPrevNode->get_children(array(
			'get_columns'=>$columns,
			'limit'=>1,
			'order_by'=>'order',
			'order_direction'=>'DESC'
		));
		$previousPage = rz_node::nudeHydrate($previousPages);
	}
	else if (is_object($parentParentNode)) {
		$previousPage = $parentParentNode;
	}
}

/*
 * Searching next readable node
 */
if ($hasChildren === true) 
{
	$nextPages = $this->getRequestedNode()->get_children(array(
		'limit'=>1
	));
	$nextPage = rz_node::nudeHydrate($nextPages);
	if (is_object($nextPage) && $nextPage->get_node_type()->name != 'pages') {
		$nextPages = $nextPage->get_children(array(
			'get_columns'=>$columns,
			'limit'=>1
		));
		$nextPage = rz_node::nudeHydrate($nextPages);
	}
}
else {
	$nextPage = $this->getRequestedNode()->get_next();
}
if (!is_object($nextPage)) {
	$nextPage = $parentNodeNav->get_next();
	if (is_object($nextPage) && $nextPage->get_node_type()->name != 'pages') {
		$nextPages = $nextPage->get_children(array(
			'get_columns'=>$columns,
			'limit'=>1
		));
		$nextPage = rz_node::nudeHydrate($nextPages);
	}
}
?>
<nav id='relative_navigation'>
	<?php if (is_object($previousPage) && $previousPage->exists()): ?>
	<a href='<?php echo $previousPage->get_node_url() ?>'>&larr; <?php echo $previousPage->getHandler()->getDisplayTitle(); ?></a>
	<?php endif ?>
	<?php if (is_object($nextPage) && $nextPage->exists()): ?>
	&nbsp;<a href='<?php echo $nextPage->get_node_url() ?>'><?php echo $nextPage->getHandler()->getDisplayTitle(); ?> &rarr;</a>
	<?php endif ?>
</nav>