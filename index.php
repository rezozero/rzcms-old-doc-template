<?php
/**
 * Copyright REZO ZERO 2014
 * 
 * 
 * 
 *
 * @file index.php
 * @copyright REZO ZERO 2014
 * @author Ambroise Maupate
 */

if (!defined("RZCMS_ENTRYPOINT")) {
	// If file directly requested, throw 403
	header('HTTP/1.0 403 Forbidden');
	exit;
}

define('TEMPLATE_FOLDER', dirname(__FILE__));
define('TEMPLATE_BASE_FOLDER', rz_core::getTemplateFolder());
define('TEMPLATE_JS_FOLDER', TEMPLATE_BASE_FOLDER.'js/');
define('TEMPLATE_CSS_FOLDER', TEMPLATE_BASE_FOLDER.'css/');
define('TEMPLATE_IMAGE_FOLDER', TEMPLATE_BASE_FOLDER.'img/');

if (rz_kernel::getInstance()->getRequestedNode() === null) {
	include(TEMPLATE_FOLDER."/404/404.php");
}
else{

	if (isset($_GET['ePub']) && $_GET['ePub'] == 1) {
		include(TEMPLATE_FOLDER."/includes/exportToEpub.php");
	}
	else {
		
		/**
		 * Default template
		 */

		include(TEMPLATE_FOLDER."/header.php");
		include(TEMPLATE_FOLDER."/content.php");
		include(TEMPLATE_FOLDER."/footer.php");
	}
}	