<?php
get_header();
$today = date( 'Ymd' );
$events_args = array(
	'post_type' => 'events',
	'posts_per_page' => -1,
	'order' => 'ASC',
	'orderby' => 'meta_value',
	'meta_key' => 'date',
	'meta_query' => array(
		array(
			'key' => 'date',
			'value' => $today,
			'compare' => '>=',
			'type' => 'DATE',
		),
	)
);
query_posts( $events_args );
echo '<div class="col col-12 col-sm-9">';
	echo '<div id="identity">';
		echo '<img src="'.get_template_directory_uri().'/assets/images/identity.gif"/>';
		echo '<img src="'.get_template_directory_uri().'/assets/images/identity.gif"/>';
	echo '</div>';

	get_template_part( 'headers', 'mobile' );

	echo '<div id="about">'.get_field( 'about', 'options' ).'</div>';
	echo '<div class="mobile">';
		get_template_part( 'social' );
	echo '</div>';
echo '</div>';
get_footer();
?>
