<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="event-datetime">
		<div class="date"><?= get_field('date') ?></div>
		<div class="time"><?= get_field('time') ?></div>
	</div>
	
	<?php
	if( has_post_thumbnail(get_the_ID()) ): 
		echo '<a href="'.get_the_permalink().'" class="event-thumb">';
			the_post_thumbnail( get_the_ID(), 'custom' );
		echo '</a>';
	else:
		echo '<div class="event-content">';
			echo '<a href="'.get_the_permalink().'">'.get_the_title().'</a>';
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
			<div class="register"><a href="<?= $register ?>"><span>Register</span></a></div>
		<?php endif; ?>
	</div>
</article>