<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<main class="content" role="main">
		<div class="row">
			<div class="col col col-12 col-sm-3 col-spacer"></div>
			<div class="col col col-12 col-sm-3 col-utility">
				<nav class="navigation" role="navigation" aria-label="<?php esc_attr_e( 'Navigation', 'twentysixteen' ); ?>">
					<h2><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h2>
					<?php
					if ( has_nav_menu( 'navigation' ) ) :
						foreach( wp_get_nav_menu_items( 'navigation' ) as $menu_item ):
							echo '<h2><a href="'.$menu_item->url.'">'.$menu_item->title.'</a></h2>';
						endforeach;
					endif;
					?>
				</nav>
				<footer class="social">
					<a href="<?= get_field( 'facebook', 'options' ) ?>" target="_blank" class="facebook social-icon">
						<?= file_get_contents(get_template_directory_uri().'/assets/images/facebook.svg'); ?>
					</a>
					<a href="<?= get_field( 'twitter', 'options' ) ?>" target="_blank" class="twitter social-icon">
						<?= file_get_contents(get_template_directory_uri().'/assets/images/twitter.svg'); ?>
					</a>
					<a href="<?= get_field( 'instagram', 'options' ) ?>" target="_blank" class="instagram social-icon">
						<?= file_get_contents(get_template_directory_uri().'/assets/images/instagram.svg'); ?>
					</a>
				</footer>
			</div>