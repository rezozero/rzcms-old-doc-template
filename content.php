<?php 

$specific_content_templates = array('contact', 'search');

if(is_object($this->getRequestedNode()) && $this->getRequestedNode()->exists())
{
	if(in_array($this->getRequestedNode()->node_name, $specific_content_templates)){
		if(file_exists(TEMPLATE_FOLDER."/content_".$this->getRequestedNode()->node_name.".php")){
			include_once(TEMPLATE_FOLDER."/content_".$this->getRequestedNode()->node_name.".php");
		}
		else {
			?>
			<h2><?php echo(dgettext("template","Node type does not have a specific template file.")) ?><br/><?php echo(TEMPLATE_FOLDER."/content_".$this->getRequestedNode()->node_name.".php"); ?></h2>
			<?php					
		}
	}
	else {
		/* --------------------
		 * On inclue le fichier PHP en fonction du type de nœud
		 * -------------------- */

		if($this->getRequestedNodeType()->exists() && file_exists(TEMPLATE_FOLDER."/content_".$this->getRequestedNodeType()->name.".php")){
			include_once(TEMPLATE_FOLDER."/content_".$this->getRequestedNodeType()->name.".php");
		}
		else {
			?>
			<h2><?php echo(dgettext("template","Node type does not have a specific template file.")) ?><br/><?php echo(TEMPLATE_FOLDER."/content_".$this->getRequestedNodeType()->name.".php"); ?></h2>
			<?php					
		}
	}
				
}

?>