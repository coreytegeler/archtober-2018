<?php
$id = get_the_ID();
$website = get_field( 'website' );
$partner_type_str = get_terms_str( $id, 'partner_type' );
$block_classes = array( 'partner-block', 'partner', 'item', 'col', 'col-12', 'col-sm-6', 'col-md-4', 'col-lg-3', 'partner' );
$row_classes = array( 'item-row', 'partner-row', 'item', 'partner', 'col', 'col-12' );
?>
<div data-id="<?= $id; ?>" data-partner-type="<?= $partner_type_str; ?>" <?php post_class( $row_classes ); ?>>
	<div class="row">
		<div class="col col-12 col-sm-4 name"><?= get_the_title(); ?></div>
		<div class="col col-12 col-sm-4 website">
			<?php if( $website ): ?>
				<a href="<?= $website ?>" target="_blank">
					<?= pretty_url( $website ); ?>
				</a>
			<?php endif; ?>
		</div>
		<div class="col col-12 col-sm-4 date"><?= get_field( 'phone' ); ?></div>
	</div>
</div>