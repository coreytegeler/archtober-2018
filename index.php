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
		echo file_get_contents(get_template_directory_uri().'/assets/images/identity.svg');
		echo file_get_contents(get_template_directory_uri().'/assets/images/identity-mobile.svg');
	echo '</div>';
	echo '<header>';
		echo '<div class="title"><h2>NYCxDESIGN</h2><div class="burger"></div></div>';
		echo '<div class="title"><h2>Building of the Day Preview</h2></div>';
	echo '</header>';
	echo '<div class="events row">';
		if ( have_posts() ) :
			while ( have_posts() ) : the_post();
				echo '<div class="col col-12 col-md-6 col-lg-6 event">';
					get_template_part( 'content', 'events' );
				echo '</div>';
			endwhile;
		endif;
	echo '</div>';
	echo '<div id="about">'.get_field( 'about', 'options' ).'</div>';
echo '</div>';
get_footer();
?>
