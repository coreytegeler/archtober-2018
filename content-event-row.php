<?php
$id = get_the_ID();
$start_date = get_field( 'date' );
$end_date = get_field( 'end_date' );
$time_of_day_str = get_terms_str( $id, 'time_of_day' );
$event_type_str = get_terms_str( $id, 'event_type' );
$time_span = get_time_span( $id );
$types = get_event_types( $id );
$partners = get_field( 'partner' );
$permalink = get_the_permalink();
$row_classes = array( 'item-row', 'event-row', 'event', 'item', 'col', 'col-12' );
if( has_term( 'botd', 'event_type' ) ):
	array_push( $row_classes, 'botd' );
endif;
if( !get_field( 'images' ) ):
	array_push( $row_classes, 'no-gallery' );
endif;
?>
<div data-id="<?= $id; ?>" data-post-type="events" data-time-of-day="<?= $time_of_day_str; ?>" data-event-type="<?= $event_type_str; ?>" data-date="<?= $start_date.( $end_date ? ','.$end_date : '' ); ?>" <?php post_class( $row_classes ); ?>>
	<a class="item-link" href="<?= $permalink; ?>">
		<div class="row">
			<div class="col col-12 col-sm-3 title"><?= get_the_title(); ?></div>
			<div class="col col-12 col-sm-2 event-type"><?= $types; ?></div>
			<div class="col col-12 col-sm-2 date">
				<?php
				echo $start_date;
				if( $end_date ):
					echo ' &ndash; '.$end_date;
				endif;
				?>
			</div>
			<div class="col col-12 col-sm-2 time"><?= $time_span; ?></div>
			<div class="col col-12 col-sm-3 partner">
				<?php
				if( $partners && sizeof( $partners ) >= 1 ):
					foreach( $partners as $partner ):
						echo '<span>'.$partner->post_title.'</span>';
					endforeach;
				endif;
				?>
			</div>
		</div>
	</a>
</div>