<?php
$id = get_the_ID();
$start_date = get_field( 'start_date' );
$end_date = get_field( 'end_date' );
$institution = get_terms_str( $id, 'institution' );
$permalink = get_the_permalink();
$block_classes = array( 'exhibition-block', 'block',  'exhibition', 'item', 'col', 'col-12', 'col-sm-6', 'col-md-4', 'col-lg-3', 'event' );
?>
<div data-id="<?= $id; ?>" data-post-type="exhibitions" <?php post_class( $block_classes ); ?>>
	<a class="item-link" href="<?= $permalink; ?>">
		<div class="dates"><?= $start_date.' - '.$end_date ?></div>
		<div class="event-title"><?= get_the_title(); ?></div>
	</a>
</div>