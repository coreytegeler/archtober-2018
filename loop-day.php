<?php
$events_query = new WP_Query( array(
	'post_type' => 'events',
	'posts_per_page' => -1,
	'order' => 'ASC',
	'orderby' => 'meta_value_num',
	'meta_key' => 'times_0_start_time',
	'meta_query' => array (
		'relation' => 'OR',
		array(
			'key' => 'date',
			'value' => $date_str,
			'compare' => '=',
			'type' => 'DATE'
		),
		array(
			'relation' => 'AND',
			array(
				'key' => 'date',
				'value' => $date_str,
				'compare' => '<=',
				'type' => 'DATE'
			),
			array(
				'key' => 'end_date',
				'compare' => '>=',
				'value' => $date_str,
				'type' => 'DATE',
			)
		)
	)
) );

if( $events_query->have_posts() ):
	while( $events_query->have_posts() ):
		$events_query->the_post();
		if( !has_term( 'botd', 'event_type' ) ):
			get_template_part( 'content', 'event' );
		endif;
	endwhile;
	wp_reset_postdata();
endif;
?>