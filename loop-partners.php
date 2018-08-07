<div id="partners-loop" class="loop partners-loop" data-view="list">
	<div class="list-header">
		<div class="fix">
			<div class="col col-4 col-header name">Partner</div>
			<div class="col col-4 col-header website">Website</div>
			<div class="col col-4 col-header phone">Phone</div>
		</div>
	</div>
	<div class="row">
		<?php	
		// ALL PARTICIPANTS LOOP
		$partners_query = new WP_Query( array(
			'post_type' => 'partners',
			'posts_per_page' => -1,
			'order' => 'ASC',
			'orderby' => 'post_title',
			'tax_query' => array(
				array(
					'taxonomy' => 'partner_type',
					'field' => 'slug',
					'terms' => 'media',
					'operator' => 'NOT IN'
				)
			)
		) );
		if( $partners_query->have_posts() ):
			while( $partners_query->have_posts() ):
				$partners_query->the_post();
				get_template_part( 'content', 'partner' );
			endwhile;
			wp_reset_postdata();
		endif;
		?>
	</div>
</div>