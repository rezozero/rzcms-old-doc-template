<?php 
/**
 * Copyright REZO ZERO 2014
 * 
 * 
 * Default template 404 page
 *
 * @file 404.php
 * @copyright REZO ZERO 2014
 * @author Ambroise Maupate
 */
header('HTTP/1.0 404 Not Found');
?><!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
		<meta charset="utf-8" />
		<title><?php echo(rz_setting::get('site_title')) ?> - <?php echo (_("Error 404")); ?></title>
		<link rel="stylesheet" href="<?php echo TEMPLATE_BASE_FOLDER ?>404/style_404.css" />
		<?php rz_core::importCSSLibs(); ?>
	</head>
	<body style="border-color : <?php echo(rz_setting::get('customColour')) ?>">
		<div id="content_404">
			<a href="<?php echo rz_core::getBaseFolder() ?>" id="logo_404" style='background-image:url(<?php echo rz_document::getAdminImage()->getDocumentUrlByArray(array("width"=>100, "resampled"=>1, "retina"=>1)); ?>)'><span class="icon"></span></a>
			<h2 id="title_404"><?php echo (_("Error 404")); ?></h2>
			<p id="message_404"><?php echo (_("The page cannot be found.")); ?></p>
			<a id="return_site_link" href="<?php echo rz_core::getBaseFolder() ?>" style="color:<?php echo(rz_setting::get('customColour')) ?>"> <?php echo (_("Return to site")); ?> </a>
		</div>
		<?php rz_core::importJSCore(); ?>
	</body>
</html>