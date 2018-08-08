<div id="exhibitions-loop" class="loop exhibitions-loop" data-view="grid">
	<?php	
	$institutions = get_terms( array(
		'orderby' => 'term_order',
	  'taxonomy' => 'institution',
	  'hide_empty' => true,
	) ); 
	foreach( $institutions as $institution ):
		echo '<div class="institution row">';
			echo '<div class="col col-12">';
				echo '<div class="institution-header"><div class="fix">' . $institution->name . '</div></div>';
			echo '</div>';
			$exhibit_query = new WP_Query( array(
				'post_type' => 'exhibitions',
				'posts_per_page' => -1,
				'order' => 'ASC',
				'orderby' => 'meta_value',
				'meta_key' => 'start_date',
				'tax_query' => array(
					array(
						'taxonomy' => 'institution',
						'field' => 'slug',
						'terms' => $institution->slug,
						'operator' => 'IN'
					)
				)
			) );

			if( $exhibit_query->have_posts() ):
				while( $exhibit_query->have_posts() ):
					$exhibit_query->the_post();
					get_template_part( 'content', 'exhibition' );
				endwhile;
				wp_reset_postdata();
			endif;
		echo '</div>';
	endforeach;
?>
</div>
<article class="exhibition-overlay overlay placeholder">
	<div class="row overlay-inner">
		<div class="col col-12 col-md-6"></div>
		<div class="col col-12 col-md-6 fixed">
			<div class="gallery"><figure class="active"></figure></div>
		</div>
	</div>
</article>

