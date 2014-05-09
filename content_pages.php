<?php
if (rz_cache::get('node_'.$this->getRequestedNode()->node_id) === false) {
	ob_start();

	/*
	 * Fil d'ariane
	 */
	$parents = $this->getRequestedNode()->get_parents();
	$parentLinks = array();
	$parentIntermediaryLinks = array();
	$parentLinks[] = '<a href="'.get_base_folder().'">Home</a>';
	foreach ($parents as $key => $value) {
		if ($value->node_name != 'home') {
			if ($value->get_node_type()->name == "pages") {
				$parentIntermediaryLinks[] = '<a href="'.$value->get_node_url().'">'.$value->title.'</a>';
			}
			else {
				$parentIntermediaryLinks[] = $value->title;
			}
		}
	}
	$parentIntermediaryLinks = array_reverse($parentIntermediaryLinks);
	$parentLinks = array_merge($parentLinks, $parentIntermediaryLinks);
	$parentLinks[] = '<a href="'.$this->getRequestedNode()->get_node_url().'">'.$this->getRequestedNode()->title.'</a>';

	?>
	<h1 id="page_title"><?php echo $this->getRequestedNode()->title ?></h1>
	<?php 
	/* fil d'ariane */
	if ($this->getRequestedNode()->node_name != "home"): ?>
	<nav class="ariane">
		<?php echo(implode(' > ', $parentLinks)); ?>
		<span class='lastmod'><?php echo(strftime('%e %b %Y %R', strtotime($this->getRequestedNode()->lastmod_date))); ?></span>
	 	<a class="edit_page_link" target="_blank" href="<?php echo $this->getRequestedNode()->get_edit_page_url(); ?>"><?php echo(dgettext("template", "Edit page")); ?></a>
	</nav>	
	<?php endif ?>

	<?php if ($this->getRequestedNode()->has_children() && $this->getRequestedNode()->content != ""): ?>
	<aside id="summary">
		<h3><?php echo(dgettext("template", "Summary")); ?></h3>
		<ul class="page_summary">
		<?php recursive_menu( $this->getRequestedNode()->node_id, $this->getRequestedNode() ); ?>
		</ul>
	</aside>	
	<?php endif ?>

	<div class="content">
	<?php echo(Markdown($this->getRequestedNode()->content)) ?>
	<?php if ($this->getRequestedNode()->has_children() && $this->getRequestedNode()->content == ""): ?>

		<h3><?php echo(dgettext("template", "Summary")); ?></h3>
		<ul class="page_summary">
		<?php recursive_menu( $this->getRequestedNode()->node_id, $this->getRequestedNode() ); ?>
		</ul>

	<?php endif ?>
	</div>
	<?php include(TEMPLATE_FOLDER.'/includes/page2page_navigation.php'); 

	rz_cache::set('node_'.$this->getRequestedNode()->node_id, ob_get_clean());
}
echo rz_cache::get('node_'.$this->getRequestedNode()->node_id);

?>