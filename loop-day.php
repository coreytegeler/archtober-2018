<?php
$botd_query = new WP_Query( array(
	'post_type' => 'events',
	'posts_per_page' => 1,
	'order' => 'ASC',
	'orderby' => 'meta_value',
	'meta_key' => 'date',
	'meta_query' => array (
		'key' => 'date',
		'value' => $date_str,
		'compare' => '=',
		'type' => 'DATE'
	),
	'tax_query' => array(
		array(
			'taxonomy' => 'event_type',
			'field' => 'slug',
			'terms' => 'botd',
			'operator' => 'IN'
		)
	)
) );

if( $botd_query->have_posts() ):
	while( $botd_query->have_posts() ):
		$botd_query->the_post();
		get_template_part( 'content', 'botd' );
	endwhile;
	wp_reset_postdata();
endif;

$events_query = new WP_Query( array(
	'post_type' => 'events',
	'posts_per_page' => -1,
	'order' => 'ASC',
	'orderby' => 'meta_value',
	'meta_query' => array (
		'relation' => 'OR',
		array(
			'key' => 'start_date',
			'value' => $date_str,
			'compare' => '=',
			'type' => 'DATE'
		),
		array(
			'relation' => 'AND',
			array(
				'key' => 'start_date',
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
		get_template_part( 'content', 'event' );
	endwhile;
	wp_reset_postdata();
endif;
?>