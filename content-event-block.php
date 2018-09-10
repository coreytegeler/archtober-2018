<?php
$id = get_the_ID();
// $today = date( 'm/j/y' );
$start_date = get_field( 'date' );
$start_day = date_format( date_create( $start_date ), 'j' );
$end_date = get_field( 'end_date' );

if( $end_date ):
	$end_day = date_format( date_create( $end_date ), 'j' );
	$day_range = implode( ',', range( $start_day, $end_day ) );
else:
	$day_range = $start_day;
endif;


$time_of_day_str = get_terms_str( $id, 'time_of_day' );
$event_type_str = get_terms_str( $id, 'event_type' );
$time_span = get_time_span( $id );
$types = get_event_types( $id );
$partners = get_field( 'partner' );
$permalink = get_the_permalink();
$block_classes = array( 'event-block', 'event', 'block', 'item', 'col', 'col-12', 'col-sm-6', 'col-md-4', 'col-lg-3', 'event' );
if( has_term( 'botd', 'event_type' ) ):
	array_push( $block_classes, 'botd' );
endif;
if( !get_field( 'images' ) ):
	array_push( $block_classes, 'no-gallery' );
endif;
// $today = date_format($test, 'm/j/y');
// if( $start_date < $today && ( !$end_date || $end_date < $today ) ):
// 	array_push( $row_classes, 'past' );
// endif;



?>
<div <?php post_class( $block_classes ); ?> data-id="<?= $id; ?>" data-post-type="events" data-event-type="<?= $event_type_str; ?>" data-days="<?= $day_range ?>">
	<a class="item-link" href="<?= $permalink; ?>">
		<div class="row">
			<div class="col col-12 primary text">
				<div class="time"><?= $time_span ?></div>
				<div class="event-title"><?= get_the_title(); ?></div>
				<?php if( $types ): ?>
					<span class="event-type">&mdash;<?= $types; ?></span>
				<?php endif; ?>
			</div>
			<div class="col col-12 secondary text">
				<?php if( $partners && sizeof( $partners ) >= 1 ): ?>
					<div class="partner">
						<div>Organized by</div>
						<?php foreach( $partners as $partner ):
							echo '<span>'.$partner->post_title.'</span>';
						endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</a>
</div>