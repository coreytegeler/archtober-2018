<?php
global $post;
if( !wp_doing_ajax() ) {
	get_header();
}
$id = get_the_ID();
$content = get_the_content();
$images = get_field( 'images' );
$start_date = get_field( 'start_date' );
$end_date = get_field( 'end_date' );
$time_span = get_time_span( get_the_ID() );
$location = get_field( 'location' );
$partners = get_field( 'partner' );
$is_botd = has_term( 'botd', 'event_type', $post );
$post_classes = array( 'event-overlay', 'overlay' );
if( $is_botd ):
	array_push( $post_classes, 'botd' );
endif;
$archive_url = get_permalink( get_page_by_path( 'events' )->ID );
?>
<article data-id="<?= $id; ?>" <?php post_class( $post_classes ); ?>>
	<a href="<?= $archive_url; ?>" class="icon-btn x"></a>
	<div class="row overlay-inner">

		<div class="col col-12">
			<div class="piece event-type">
				<?php if( $is_botd ): ?>
					Building of the Day
				<?php else: ?>
					<?= the_terms( $id, 'event_type', '', ', ' ); ?>
				<?php endif; ?>
			</div>
		</div>

		<div class="col col-12 col-md-6">

			<div class="piece title">
				<h1><?= get_the_title(); ?></h1>
			</div>

			<div class="piece date-location">
				<?
				echo $start_date;
				if( $end_date ):
					echo ' &ndash; '.$end_date;
				endif;
				echo ' at '.$time_span;
				?>
				<br/>
				<?= $location; ?>
			</div>


			<?php if( !$is_botd && sizeof( $partners ) ): ?>
				<div class="piece partners">Sponsored by
					<?php foreach( $partners as $partner ):
						echo '<span>'.$partner->post_title.'</span>';
					endforeach; ?>
				</div>
			<?php endif; ?>

			<?php
			if( have_rows( 'times', $id ) ):
				echo '<div class="piece times">';
					while( have_rows( 'times', $id ) ): the_row();
						$start_time = get_sub_field( 'start_time' );
						$registration = get_sub_field( 'registration' );
						$register_str = 'Register here';
						if( true ) {
							$register_str .= ' for '.$start_time;
						}
						echo '<a href="'.$registration.'">'.$register_str.'</a>';
						if( get_sub_field( 'sold_out' ) ):
							echo ' [sold out]';
						endif;
						echo '</br>';
					endwhile;
				echo '</div>';
			endif;
			?>

			

			<div class="piece content">
				<?= $content; ?>
			</div>

		</div>

		<div class="col col-12 col-md-6">
			<?php
			if( $images ):
				echo '<div class="gallery">';
					foreach( $images as $i => $image ):
						echo '<figure data-index="'.$i.'" class="'.($i==0?'active':'').'">';
							echo wp_get_attachment_image( $image['ID'], 'large' );
						echo '</figure>';
					endforeach;
					echo '<div class="row">';
						echo '<div class="col col-auto dots">';
							$i = 0;
							while( $i < sizeof( $images ) ):
								echo '<div class="dot'.($i==0?' active':'').'" data-index="'.$i.'">';
									echo '<span>'.($i+1).'</span>';
								echo '</div>';
								$i++;
							endwhile;
						echo '</div>';
						echo '<div class="col captions">';
							foreach( $images as $i => $image ):
								echo '<figcaption data-index="'.$i.'" class="'.($i==0?'active':'').'">';
									echo $image['caption'];
								echo '</figcaption>';
							endforeach;
						echo '</div>';
					echo '</div>';
				echo '</div>';
			endif;
			?>
		</div>

	</div>
</article>
<?php 
if ( !wp_doing_ajax() ) {
	get_template_part( 'loop', 'events' );
	get_footer();
}
?>