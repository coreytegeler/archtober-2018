<?php
$events_block_query = new WP_Query( array(
	'post_type' => 'events',
	'posts_per_page' => -1,
	'order' => 'ASC',
	'orderby' => 'meta_value_num',
	'meta_key' => 'times_0_start_time',
) );

if( $events_block_query->have_posts() ):
	while( $events_block_query->have_posts() ):
		$events_block_query->the_post();
		if( !has_term( 'botd', 'event_type' ) ):
			get_template_part( 'content', 'event-block' );
		endif;
	endwhile;
	wp_reset_postdata();
endif;
?>