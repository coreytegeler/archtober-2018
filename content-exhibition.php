<?php
$id = get_the_ID();
$start_date = get_field( 'start_date' );
$end_date = get_field( 'end_date' );
$institution = get_terms_str( $id, 'institution' );
$permalink = get_the_permalink();
$has_thumb = has_post_thumbnail( get_the_ID() );
$block_classes = array( 'exhibition-block', 'block',  'exhibition', 'item', 'col', 'col-12', 'event' );
if( $has_thumb ):
	array_push( $block_classes, 'col-sm-12', 'col-md-8', 'col-lg-6' );
else:
	array_push( $block_classes, 'col-sm-6', 'col-md-4', 'col-lg-3' );
endif;
?>
<div data-id="<?= $id; ?>" data-post-type="exhibitions" <?php post_class( $block_classes ); ?>>
	<a class="item-link" href="<?= $permalink; ?>">
		<div class="row">
			<?php if( $has_thumb ): ?>
				<div class="col col-12 mobile">
					<img class="block-thumb" src="<?= the_post_thumbnail_url( 'custom' ); ?>"/>
				</div>
			<div class="col col-12 col-sm-6 text">
			<?php else: ?>
				<div class="col col-12 text">
			<?php endif; ?>
			<?php if( $start_date ): ?>
				<div class="dates">
					<?= $start_date.' &ndash; '; ?>
					<?php if( $end_date ): ?>
						<?= $end_date ?>
					<?php else: ?>
						<?= 'Ongoing' ?>
					<?php endif; ?>			
				</div>
			<?php endif; ?>
			<div class="event-title"><?= get_the_title(); ?></div>
			</div>
			<?php if( $has_thumb ): ?>
				<div class="col col-12 col-sm-6 desktop">
					<div class="block-thumb" style="background-image:url(<?= the_post_thumbnail_url( 'custom' ); ?>)"></div>
				</div>
			<?php endif; ?>
		</div>
	</a>
</div>