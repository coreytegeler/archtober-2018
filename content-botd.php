<?php
$block_classes = array( 'event-block', 'event', 'block', 'item', 'col', 'col-12', 'col-sm-12', 'col-md-8', 'col-lg-6', 'botd' );
?>
<article data-id="<?php the_ID(); ?>" data-post-type="events" <?php post_class( $block_classes ); ?>>
	<a class="item-link" href="<?= the_permalink(); ?>">
		<div class="row">
			<div class="col col-12 mobile">
				<?php if( has_post_thumbnail( get_the_ID() ) ): ?>
					<img class="block-thumb" src="<?= the_post_thumbnail_url( 'custom' ); ?>"/>
				<?php endif; ?>
			</div>
			<div class="col col-12 col-sm-6 text">
				<div class="event-title"><?= get_the_title(); ?></div>
				<div class="event-type">&mdash;Building of the Day</div>
			</div>
			<div class="col col-12 col-sm-6 desktop">
				<?php if( has_post_thumbnail( get_the_ID() ) ): ?>
					<div class="block-thumb" style="background-image:url(<?= the_post_thumbnail_url( 'custom' ); ?>)"></div>
				<?php endif; ?>
			</div>
		</div>
	</a>
</article>