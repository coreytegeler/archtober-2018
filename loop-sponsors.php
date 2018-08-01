<?php
$sponsor_types = get_terms( array(
	'orderby' => 'term_order',
  'taxonomy' => 'sponsor_type',
  'hide_empty' => true,
) );
echo '<div id="sponsors-loop" class="loop sponsors-loop">';
foreach( $sponsor_types as $sponsor_type ):
	echo '<div class="sponsor-type row">';
		if( $sponsor_type->slug != 'main-sponsors' ):
			echo '<div class="sponsor-type-name col col-12">'.$sponsor_type->name.'</div>';
		endif;
		$sponsors_args = array(
			'post_type' => 'sponsors',
			'posts_per_page' => -1,
			'tax_query' => array ( array(
				'taxonomy' => 'sponsor_type',
				'field' => 'slug',
				'terms' => $sponsor_type->slug,
				'operator' => 'IN'
			) )
		);

		query_posts( $sponsors_args );

		if ( have_posts() ):
			while ( have_posts() ) : the_post();
				if( $sponsor_type->slug == 'main-sponsors' ):
					$sponsor_classes = 'col-sm-12 col-md-6 col-lg-6';
					$img_class = 'col-12 col-sm-6 col-md-8 col-lg-6';
				else:
					$sponsor_classes = 'col-sm-6 col-md-4 col-lg-3';
					$img_class = 'col-12 col-sm-12';
				endif;

				echo '<div class="sponsor col col-12 '.$sponsor_classes.' '.$sponsor_type->slug.'">';
					if( has_post_thumbnail(get_the_ID()) ): 
						echo '<div class="sponsor-thumb row">';
							echo '<div class="'.$img_class.'">';
								the_post_thumbnail( 'full' );
							echo '</div>';
						echo '</div>';
					endif;
					if( $sponsor_type->slug == 'main-sponsors' ):
						the_excerpt();
					endif;
				echo '</div>';
			endwhile;
		endif;

		wp_reset_query();

	echo '</div>';
endforeach;
echo '</div>';
?>