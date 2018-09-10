<?php
if( !wp_doing_ajax() ) {
	get_header();
}
$id = get_the_ID();
$post = get_post( $id );
$content = wpautop( $post->post_content );
$images = get_field( 'images' );
$start_date = get_field( 'date' );
$end_date = get_field( 'end_date' );
$time_span = get_time_span( get_the_ID() );
$location = get_field( 'location' );
$architects = wpautop( get_field( 'architects' ) );
$partners = get_field( 'partner' );
$event_types = get_the_terms( $id, 'event_type' );
$is_botd = has_term( 'botd', 'event_type', $post );
$post_classes = array( 'event-overlay', 'overlay' );
if( $is_botd ):
	array_push( $post_classes, 'botd' );
endif;
if( !wp_doing_ajax() ) {
	array_push( $post_classes, 'show' );
}
$archive_url = get_permalink( get_page_by_path( 'events' )->ID );
?>
<article data-id="<?= $id; ?>" <?php post_class( $post_classes ); ?>>
	<a href="<?= $archive_url; ?>" class="icon-btn x" onclick="void(0)"></a>
	<div class="row overlay-inner">
		<div class="col col-12">
			<div class="piece event-type desktop">
				<?php
				if( $is_botd ):
					echo 'Building of the Day';
				elseif( $event_types ):
					foreach ( $event_types as $event_type ):
						echo '<span>'.$event_type->name.'</span>';
					endforeach;
				endif;
				?>
			</div>
		</div>
		<div class="col col-12 col-sm-6">
			<div class="piece title">
				<h1><?= get_the_title(); ?></h1>
			</div>

			<div class="piece date-location">
				<?php
				if( $start_date ):
					echo date_format( date_create( $start_date ), 'M j' );
					if( $end_date ):
						echo ' &ndash; '.date_format( date_create( $end_date ), 'M j' );
					endif;
				endif;
				echo ' at '.$time_span;
				?>
				<br/>
				<?= $location; ?>
			</div>

			<?php if( !$is_botd && $partners && sizeof( $partners ) > 0 ): ?>
				<div class="piece partner">Organized by
					<?php foreach( $partners as $partner ):
						echo '<span>'.$partner->post_title.'</span>';
					endforeach; ?>
				</div>
			<?php endif; ?>
			
			<?php if( $is_botd && $architects ): ?>
				<div class="piece architects">
					<?= $architects; ?>
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
						echo '<a href="'.http( $registration ).'" target="_blank">'.$register_str.'</a>';
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

		<div class="col col-12 col-sm-6 fixed">
			<div class="piece event-type mobile">
				<?php
				if( $is_botd ):
					echo 'Building of the Day';
				elseif( $event_types ):
					foreach ( $event_types as $event_type ):
						echo '<span>'.$event_type->name.'</span>';
					endforeach;
				endif;
				?>
			</div>
			<?php
			if( $images ):
				echo '<div class="gallery">';
					foreach( $images as $i => $image ):
						echo '<figure data-index="'.$i.'" class="'.($i==0?'active':'').'">';
							echo wp_get_attachment_image( $image['ID'], 'large' );
						echo '</figure>';
					endforeach;
					echo '<div class="row">';
						if( sizeof( $images ) > 1 ):
							echo '<div class="col col-auto dots">';
								$i = 0;
								while( $i < sizeof( $images ) ):
									echo '<div class="dot'.($i==0?' active':'').'" data-index="'.$i.'">';
										echo '<span>'.($i+1).'</span>';
									echo '</div>';
									$i++;
								endwhile;
							echo '</div>';
						endif;
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