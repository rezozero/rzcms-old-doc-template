<?php 
rz_core::baseHTML($this->getMetaTitle()); 
?>
	<base href="<?php echo rz_core::getBaseFolder() ?>" />
	<?php if ( has_touchscreen() )  {  ?>
	<meta name="viewport" content="initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width"></meta>
	<?php } ?>
	<link rel="stylesheet" href="<?php echo TEMPLATE_CSS_FOLDER; ?>style.css" type="text/css" />
	<!--[if lt IE 9]>
	<link rel="stylesheet/less" type="text/css" href="<?php echo TEMPLATE_CSS_FOLDER; ?>style_ie.css">
	<![endif]-->
	<?php
	rz_core::importWebFonts();						
	rz_core::importCSSLibs();
	rz_core::importJSEssentials();
	?>
</head>
<body>
	<header>
		<h2><a href="<?php echo rz_core::getBaseFolder(); ?>"><?php echo rz_setting::get("site_title") ?></a></h2>
		<form method="get" action='<?php echo rz_core::getBaseFolder() ?>page/search'>
			<input type="search" name="q" placeholder="<?php echo(dgettext("template", "Search in doc")); ?>" value="" />
		</form>
		<p class="epub"><a href="<?php echo rz_core::getBaseFolder().'?ePub=1' ?>"><?php echo(dgettext("template", "Download ePub")); ?></a></p>
	</header>
<?php include(TEMPLATE_FOLDER."/includes/main_navigation.php"); ?>