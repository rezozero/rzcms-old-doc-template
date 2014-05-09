<ul id="main_navigation" class="navigation">
	<?php 
	$menuTimer = new rz_timer('Navigation Time'); $menuTimer->start();

	$cacheHash = 'doc_navigation_'.rz_user::getCurrent()->rank;


	if (rz_cache::get($cacheHash) === false ) {
		ob_start();
		$homeNode = $this->getHomeNode();
		recursive_menu( $homeNode->node_id, $this->getRequestedNode() ); 
		rz_cache::set($cacheHash, ob_get_clean());
	}
	echo(rz_cache::get($cacheHash));

	$menuTimer->stop();
	$this->timers[] = $menuTimer;
	?>
	<div class='clearfloat'></div>
</ul><?php 

function recursive_menu( $parent_node_id, &$requestedNode )
{
 	$menu_entries = rz_node::get_rows(array(
 		"get_column"=>array(
 			'node_id',
 			'node_name',
 			'parent_node_id',
 			'node_type_id',
 			'url_token'
 		),
 		"parent_node_id"=>$parent_node_id, 
 		"visible"=>1, 
 		"order_by"=>"order"
 	));

	while ($menu_entry = rz_node::nudeHydrate($menu_entries)) {
		$type = $menu_entry->get_node_type();
		$title = $menu_entry->getHandler()->getDisplayTitle();

		if ($menu_entry->has_children()) 
		{
		?><li class="<?php echo($type->name); ?> has_children"><?php 

			if ($type->name == "neutral"){
				?>
				<h4><?php echo $title ?></h4>
				</li><?php 

				recursive_menu( $menu_entry->node_id, $requestedNode); 

			} else {
				?><a href="<?php echo $menu_entry->get_node_url() ?>"><?php echo $title ?></a>
				<ul class="sub_navigation navigation"><?php 
					recursive_menu( $menu_entry->node_id, $requestedNode); 
				?></ul>
				</li><?php
			} 
		}
		else if($type->name != "neutral") {
		?><li class=""><a href="<?php echo $menu_entry->get_node_url() ?>"><?php echo $title ?></a></li><?php
		}
	}
} 
?>