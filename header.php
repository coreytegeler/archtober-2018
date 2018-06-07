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
	<title><?php bloginfo( 'name' ); ?></title>
</head>

<body <?php body_class(); ?>>
	<main class="content" role="main">
		<div class="row">
			<div class="col col col-12 col-sm-3 col-spacer"></div>
			<div class="col col col-12 col-sm-3 col-utility">
				<?php get_template_part( 'nav' ); ?>
				<?php get_template_part( 'social' ); ?>
			</div>