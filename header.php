<?php
global $post;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
		gtag('config', 'UA-25907718-1');
	</script>

	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<?php wp_head(); ?>
	<title><?php bloginfo( 'name' ); ?></title>
</head>

<body <?php body_class(); ?>>

	<?php $identity_src = get_template_directory_uri() . '/assets/images/identity.svg'; ?>
	<div id="identity" class="row">
		<div class="fill red"></div>
		<?= file_get_contents( $identity_src ); ?>
		<div class="fill orange"></div>
		<div class="instruct">
			<div class="desktop">scroll of click to enter the site</div>
			<div class="mobile">scroll or tap</div>
		</div>
	</div>

	<main class="content" role="main">
		<?php get_template_part( 'head' ); ?>
		<div class="main-inner">