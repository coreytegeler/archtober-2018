<?php $url = get_field('url'); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<!-- <a href="<?= $url ?>" target="_blank"> -->
		<div class="excerpt">
			<?php the_excerpt(); ?>
		</div>
		<?php
		if( has_post_thumbnail(get_the_ID()) ): 
			echo '<div class="sponsor-thumb">';
				the_post_thumbnail( 'full' );
			echo '</div>';
		endif;
		?>
	<!-- </a> -->
</article>