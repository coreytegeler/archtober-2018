<?php
$et_param = get_query_var( 'event_types' );
$ed_param = get_query_var( 'event_date' );

$today = date( 'm/j/y' );
$botd_id = get_term_by( 'slug', 'botd', 'event_type' )->term_id;
$intro = get_field( 'intro', 'option' );
echo '<div id="intro">';
	echo $intro;
	echo '<div class="sm"></div>';
	echo '<div class="lg"></div>';
echo '</div>';
?>
<div id="events-loop" class="loop events-loop" data-view="<?= $et_param || $ed_param ? 'list' : 'grid'; ?>">
	<div class="grid-view">
		<?php	
		$day_int = 1;
		while( $day_int <= 31 ):
			$date_str = '2018-10-'.$day_int;
			$date = date_create( $date_str );
			$date_format = date_format( $date, 'l, M j' );
			$past = ( date_format( $date, 'm/j/y' ) < $today ? ' past' : '' );

			echo '<div class="row day day-loop'.$past.'" data-date="'.$date_str.'">';
				echo '<div class="col col-12">';
					echo '<div class="fix-header date-header">';
						echo '<div class="fix">';
							if( $day_int != 1 ):
								echo '<div class="arrow" data-direction="prev"></div>';
							endif;
								echo $date_format;
							if( $day_int != 31 ):
								echo '<div class="arrow" data-direction="next"></div>';
							endif;
						echo '</div>';
					echo '</div>';
				echo '</div>';

				// echo '<div class="event-block botd block event placeholder col-12 col-sm-12 col-md-8 col-lg-6"><div class="item-link"></div></div>';
				// echo '<div class="event-block block event placeholder col col-12 col-sm-6 col-md-4 col-lg-3"><div class="item-link"></div></div>';
				// echo '<div class="event-block block event placeholder col col-12 col-sm-6 col-md-4 col-lg-3"><div class="item-link"></div></div>';
				// echo '<div class="event-block block event placeholder col col-12 col-sm-6 col-md-4 col-lg-3"><div class="item-link"></div></div>';

				$events_block_query = new WP_Query( array(
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

				if( $events_block_query->have_posts() ):
					while( $events_block_query->have_posts() ):
						$events_block_query->the_post();
						if( !has_term( 'botd', 'event_type' ) ):
							get_template_part( 'content', 'event-block' );
						endif;
					endwhile;
					wp_reset_postdata();
				endif;

				$day_int++;
			echo '</div>';
		endwhile; ?>
	</div>

	<div class="list-view">
		<div class="list-header">
			<div class="fix">
				<div class="col col-3 col-header title"><span>Event Title</span></div>
				<div class="col col-2 col-header event_type">
					<div class="popup">
						<div class="popup-header"><span>Type</span></div>
						<div class="popup-content">
							<div class="toggles">
								<?php 
								$event_types = get_terms( array(
							    'taxonomy' => 'event_type',
							    'hide_empty' => false,
								) );
								foreach( $event_types as $event_type ):
									$filter_classes = 'toggle filter';
									if( $et_param && $et_param == $event_type->slug ):
										$filter_classes .= ' active';
									elseif( !$et_param ):
										$filter_classes .= ' active secret';
									endif;
									echo '<div class="'.$filter_classes.'" data-filter="event-type" data-slug="'.$event_type->slug.'" onclick="void(0)">';
										echo $event_type->name;
									echo '</div>';
								endforeach;
								echo '<div class="toggle filter clear" data-filter="event-type" data-slug="clear" onclick="void(0)">Reset filters</div>';
								?>
							</div>
						</div>
					</div>
				</div>
				<div class="col col-2 col-header date">
					<div class="popup">
						<div class="popup-header"><span>Date</span></div>
						<div class="popup-content">
							<div class="toggles calendar">
								<?php
								$week = array( 'M','T','W','T','F','S','S' );
								foreach( $week as $dow ):
									echo '<div class="day dow"><div class="square"><span>'.$dow.'</span></div></div>';
								endforeach;
								$day = 1;
								while( $day <= 31 ):
									$date = '10/'.$day.'/18';
									$filter_classes = 'day toggle filter';
									if( $ed_param && $ed_param == $date ):
										$filter_classes .= ' active';
									elseif( !$ed_param ):
										$filter_classes .= ' active secret';
									endif; 
									echo '<div class="'.$filter_classes.'" data-filter="date" data-slug="'.$date.'" onclick="void(0)">';
										echo '<div class="square"><span>'.$day.'</span></div>';
									echo '</div>';
									$day++;
								endwhile;
								?>
								<div class="clear-space"><div class="clear" onclick="void(0)">clear</div></div>
							</div>
						</div>
					</div>
				</div>
				<div class="col col-2 col-header time">
					<div class="popup">
						<div class="popup-header"><span>Time</span></div>
						<div class="popup-content">
							<div class="toggles">
								<?php 
								$times_of_day = get_terms( array(
									'orderby' => 'term_order',
							    'taxonomy' => 'time_of_day',
							    'hide_empty' => false,
								) );
								foreach( $times_of_day as $time_of_day ):
									echo '<div class="toggle filter active secret" data-filter="time-of-day" data-slug="'.$time_of_day->slug.'" onclick="void(0)">';
										echo $time_of_day->name;
									echo '</div>';
								endforeach;
								echo '<div class="toggle filter clear" data-filter="time-of-day" data-slug="clear" onclick="void(0)">clear</div>';
								?>
							</div>
						</div>
					</div>
				</div>
				<div class="col col-3 col-header partner" data-sort="partner">
					<div class="sort-header"><span>Partner</span></div>
				</div>
			</div>
		</div>
		<?php
		$day_int = 1;
		// while( $day_int <= 31 ):
		// $date_str = '2018-10-'.$day_int;
		// $date = date_create( $date_str );
		// $date_format = date_format( $date, 'l, M j' );
		// $past = ( date_format( $date, 'm/j/y' ) < $today ? ' past' : '' );
		echo '<div class="row day-loop '.$past.'" data-date="'.$date_str.'">';

			$events_row_query = new WP_Query( array(
				'post_type' => 'events',
				'posts_per_page' => -1,
				'order' => 'ASC',
				'orderby' => 'meta_value_num',
				'meta_key' => 'date',
				// 'meta_query' => array (
				// 	'relation' => 'OR',
				// 	array(
				// 		'key' => 'date',
				// 		'value' => $date_str,
				// 		'compare' => '=',
				// 		'type' => 'DATE'
				// 	),
				// 	array(
				// 		'relation' => 'AND',
				// 		array(
				// 			'key' => 'date',
				// 			'value' => $date_str,
				// 			'compare' => '<=',
				// 			'type' => 'DATE'
				// 		),
				// 		array(
				// 			'key' => 'end_date',
				// 			'compare' => '>=',
				// 			'value' => $date_str,
				// 			'type' => 'DATE',
				// 		)
				// 	)
				// )
			) );



			if( $events_row_query->have_posts() ):
				while( $events_row_query->have_posts() ):
					$events_row_query->the_post();
					if( !has_term( 'botd', 'event_type' ) ):
						get_template_part( 'content', 'event-row' );
					endif;
				endwhile;
				wp_reset_postdata();
			endif;

		echo '</div>';
		// $day_int++;
		// endwhile;
		?>
	</div>
</div>
<article class="event-overlay overlay placeholder">
	<div class="row overlay-inner">
		<div class="col col-12 col-md-6"></div>
		<div class="col col-12 col-md-6 fixed">
			<div class="gallery"><figure class="active"></figure></div>
		</div>
	</div>
</article>

