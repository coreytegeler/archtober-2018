<?php
$events_rows_query = new WP_Query( array(
	'post_type' => 'events',
	'posts_per_page' => -1,
	'order' => 'ASC',
	'orderby' => 'meta_value_num',
	'meta_key' => 'date',
) );


if( $events_rows_query->have_posts() ):
	while( $events_rows_query->have_posts() ):
		$events_rows_query->the_post();
		get_template_part( 'content', 'event-row' );
	endwhile;
	wp_reset_postdata();
endif;
?>