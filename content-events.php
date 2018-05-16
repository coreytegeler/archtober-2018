<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="event-datetime">
		<div class="date"><?= get_field('date') ?></div>
		<div class="time"><?= get_field('time') ?></div>
	</div>
	
	<?php
	if( has_post_thumbnail(get_the_ID()) ): 
		echo '<div class="event-thumb">';
			the_post_thumbnail( 'custom' );
		echo '</div>';
	else:
		echo '<div class="event-content">';
			echo get_the_title();
			the_excerpt();
		echo '</div>';
	endif;
	?>
	<div class="event-info">
		<?php if( $location = get_field('location') ): ?>
			<div class="location"><?= $location ?></div>
		<?php endif; ?>
		<?php if( $partner = get_field('partner') ): ?>
			<div class="partner"><?= $partner ?></div>
		<?php endif; ?>
		<?php if( $register = get_field('register') ): ?>
			<div class="register"><a href="<?= $register ?>" target="_blank"><span>Register</span></a></div>
		<?php endif; ?>
	</div>
</article>