<?php
/*
Template Name: About
*/
get_header();
?>

<div class="row">
	<div class="col col-12 col-md-6">
		<?= wpautop( $post->post_content ); ?>
	</div>
	<div class="col col-12 col-md-6">
		FAQs
		<?php
		if( have_rows( 'faqs', $post_id ) ):
			while( have_rows( 'faqs', $post_id ) ): the_row();
				$question = get_sub_field( 'question' );
				$answer = get_sub_field( 'answer' );
				echo '<div class="faq">';
					echo '<div class="question">'.$question.'</div>';
					echo '<div class="answer">'.$answer.'</div>';
				echo '</div>';
			endwhile;
		endif;
		?>
	</div>
</div>

<?php get_footer(); ?>
