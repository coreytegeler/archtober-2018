<?php
/**
 * Template Name: Events
 */
get_header();
$events_args = array(
	'post_type' => 'events',
	'posts_per_page' => -1,
	'order' => 'ASC',
	'orderby' => 'meta_value',
	'meta_key' => 'date',
);
query_posts( $events_args );
echo '<div class="col col-9">';
	echo '<div class="events row">';
		if ( have_posts() ) :
			while ( have_posts() ) : the_post();
				echo '<div class="col col-6 event">';
					get_template_part( 'content', 'events' );
				echo '</div>';
			endwhile;
		endif;
	echo '</div>';
echo '</div>';
get_footer();
?>
