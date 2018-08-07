<?php
$id = get_the_ID();
$today = date( 'm/j/y' );
$start_date = get_field( 'date' );
$end_date = get_field( 'end_date' );
$time_of_day_str = get_terms_str( $id, 'time_of_day' );
$event_type_str = get_terms_str( $id, 'event_type' );
$time_span = get_time_span( $id );
$types = get_event_types( $id );
$partners = get_field( 'partner' );
$permalink = get_the_permalink();
$block_classes = array( 'event-block', 'event', 'block', 'item', 'col', 'col-12', 'col-sm-6', 'col-md-4', 'col-lg-3', 'event' );
$row_classes = array( 'item-row', 'event-row', 'event', 'item', 'col', 'col-12' );
if( has_term( 'botd', 'event_type' ) ):
	array_push( $block_classes, 'botd' );
	array_push( $row_classes, 'botd' );
endif;
$today = date_format($test, 'm/j/y');
if( $start_date < $today && ( !$end_date || $end_date < $today ) ):
	array_push( $row_classes, 'past' );
endif;
?>
<div data-id="<?= $id; ?>" data-post-type="events" data-event-type="<?= $event_type_str; ?>" <?php post_class( $block_classes ); ?>>
	<a class="item-link" href="<?= $permalink; ?>">
		<div class="row">
			<div class="col col-12 primary text">
				<div class="time"><?= $time_span ?></div>
				<div class="event-title"><?= get_the_title(); ?></div>
				<?php if( $types ): ?>
					<span class="dash">&mdash;</span>
					<span class="event-type"><?= $types; ?></span>
				<?php endif; ?>
			</div>
			<div class="col col-12 secondary text">
				<?php if( sizeof( $partners ) >= 1 ): ?>
					<div class="partner">Organized by
						<?php foreach( $partners as $partner ):
							echo '<span>'.$partner->post_title.'</span>';
						endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</a>
</div>

<div data-id="<?= $id; ?>" data-post-type="events" data-time-of-day="<?= $time_of_day_str; ?>" data-event-type="<?= $event_type_str; ?>" data-date="<?= $start_date.( $end_date ? ','.$end_date : '' ); ?>" <?php post_class( $row_classes ); ?>>
	<a class="item-link" href="<?= $permalink; ?>">
		<div class="row">
			<div class="col col-3 title"><?= get_the_title(); ?></div>
			<div class="col col-2 event-type"><?= $types; ?></div>
			<div class="col col-2 date">
				<?php
				echo $start_date;
				if( $end_date ):
					echo ' &ndash; '.$end_date;
				endif;
				?>
			</div>
			<div class="col col-2 time"><?= $time_span; ?></div>
			<div class="col col-3 partner">
				<?php
					if( sizeof( $partners ) >= 1 ):
						foreach( $partners as $partner ):
							echo '<span>'.$partner->post_title.'</span>';
						endforeach;
					endif;
				?>
			</div>
		</div>
	</a>
</div>