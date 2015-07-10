<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo('charset');?>" />
		<title><?php
				if (is_home()) {
					bloginfo('name');
					echo ' - ';
					bloginfo('description');
				} else {
					wp_title(' - ', true, 'right');
					bloginfo('name');
				} ?></title>
		<?php wp_head(); ?>
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<link href="<?php bloginfo('template_directory') ?>/style.css" media="screen" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<div class="container">
			<header class="header">
				<h1 class="title"><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
				<nav>
					<?php wp_nav_menu( array( 'theme_location' => 'primary-menu' ) ); ?>
				</nav>
                
                <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
                
			</header>
