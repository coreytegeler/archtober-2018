<?php
/**
 * Template Name: Sponsors
 */
get_header();
$sponsors_args = array(
	'post_type' => 'sponsors',
	'posts_per_page' => -1,
	'order' => 'ASC'
);
query_posts( $sponsors_args );
echo '<div class="col col-12 col-sm-9">';
	get_template_part( 'headers', 'mobile' );
	echo '<div class="sponsors row">';
		if ( have_posts() ) :
			while ( have_posts() ) : the_post();
				echo '<div class="col col-12 col-md-6 sponsor">';
					get_template_part( 'content', 'sponsors' );
				echo '</div>';
			endwhile;
		endif;
	echo '</div>';
echo '</div>';
get_footer();
?>
