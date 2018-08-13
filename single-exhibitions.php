<?php
if( !wp_doing_ajax() ) {
	get_header();
}
$id = get_the_ID();
$content = wpautop( $post->post_content );
$images = get_field( 'images' );
$start_date = get_field( 'start_date' );
$end_date = get_field( 'end_date' );
$open_times = get_field( 'open_times' );
$institutions = wp_get_post_terms( $id, 'institution' );
$address = get_field( 'address' );
$more_info = get_field( 'more_info' );
$post_classes = array( 'exhibition-overlay', 'overlay' );
$archive_url = get_permalink( get_page_by_path( 'exhibitions' )->ID );
?>
<article data-id="<?= $id; ?>" <?php post_class( $post_classes ); ?>>
	<a href="<?= $archive_url; ?>" class="icon-btn x" onclick="void(0)"></a>
	<div class="row overlay-inner">

		<div class="col col-12">
			<div class="piece exhibition-type">Exhibition</div>
		</div>

		<div class="col col-12 col-md-6">

			<div class="piece title">
				<h1><?= get_the_title(); ?></h1>
			</div>

			<?php if( $start_date ): ?>
				<div class="piece dates">
					<?= date_format( date_create( $start_date ), 'M j' ).' &ndash; '; ?>
					<?php if( $end_date ): ?>
						<?= date_format( date_create( $end_date ), 'M j' ); ?>
					<?php else: ?>
						<?= 'Ongoing' ?>
					<?php endif; ?>		
					<?php if( $open_times ): ?>
						<?= '<br/>'.$open_times ?>	
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<div class="piece institution">
				<?php
				if( $institutions && sizeof( $institutions ) ):
					foreach( $institutions as $institution ):
						echo '<span>'.$institution->name.'</span>';
					endforeach;
					echo '<br/>';
				endif;
				echo $address;
				if( $more_info ):
					echo '<br/>';
					echo '<a href="'.http( $more_info ).'" target="_blank">More Information</a>';
				endif;
				?>
			</div>

			<div class="piece content">
				<?= $content; ?>
			</div>

		</div>

		<div class="col col-12 col-sm-6 fixed">
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
	get_template_part( 'loop', 'exhibitions' );
	get_footer();
}
?>