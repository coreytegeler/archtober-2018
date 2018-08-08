<?php global $post; ?>
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
<?php
$body_classes = array( $post->post_type, $post->post_name );
if( is_singular( 'events' ) ):
	array_push( $body_classes, 'overlay-open' );
endif;
?>
<body <?php body_class( $body_classes ); ?>>
	<?php $logo_src = get_template_directory_uri() . '/assets/images/logo.svg'; ?>
	<?php $background = get_field( 'background', 'options' ); ?>
	<div id="identity" class="row">
		<div class="logo"><?= file_get_contents( $logo_src ); ?></div>
		<div class="background" style="background-image:url(<?= $background['url']; ?>)"></div>
		<div class="instruct">
			<div class="desktop">click or scroll to enter</div>
			<div class="mobile">tap or scroll to enter</div>
		</div>
	</div>

	<main class="content" role="main">
		<?php get_template_part( 'head' ); ?>
		<div class="main-inner">