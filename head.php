<div class="nav-icon icon-btn burger" onclick="void(0)"></div>
<div class="nav-icon icon-btn x" onclick="void(0)"></div>
<nav>
	<div class="row top">
		<div class="col col-12">
			<ul class="nav-menu">
				<?php
				$nav_items = wp_get_nav_menu_items( 'navigation' );
				foreach( $nav_items as $nav_item ):
					echo '<li class="menu-item"><a href="'.$nav_item->url.'">'.$nav_item->title.'</a></li>';
				endforeach;
				// echo '<li class="menu-item archive">';
				// echo '<span onclick="void(0)">Archive</span>';
				// for( $year = 2017; $year >= 2011; $year-- ):
				// 	echo '<a class="menu-item year" href="https://archtober.org/'.$year.'" target="_blank">'.$year.'</a>';
				// endfor;
				?>
			</ul>
		</div>
	</div>
	<div class="row bottom">
		<div class="col col-12 col-sm-6">
			<div class="social">
				<div class="icons">
					<a href="mailto:<?= get_field( 'email', 'options' ) ?>?subject=<?= get_field( 'email_subject', 'options' ) ?>" class="email social-icon">
						<?= file_get_contents(get_template_directory_uri().'/assets/images/email.svg'); ?>
					</a>
					<a href="<?= get_field( 'facebook', 'options' ) ?>" target="_blank" class="facebook social-icon">
						<?= file_get_contents(get_template_directory_uri().'/assets/images/facebook.svg'); ?>
					</a>
					<a href="<?= get_field( 'twitter', 'options' ) ?>" target="_blank" class="twitter social-icon">
						<?= file_get_contents(get_template_directory_uri().'/assets/images/twitter.svg'); ?>
					</a>
					<a href="<?= get_field( 'instagram', 'options' ) ?>" target="_blank" class="instagram social-icon">
						<?= file_get_contents(get_template_directory_uri().'/assets/images/instagram.svg'); ?>
					</a>
				</div>
			</div>
		</div>
		<div class="col col-12 col-sm-6">
			<div class="footer">
				<a href="<?= get_field( 'privacy_policy', 'options' ) ?>" class="pp">Privacy Policy</a>
				<!-- <a href="<?#= get_field( '', 'options' ) ?>" class="subscribe">Subscribe to Email</a> -->
				<a href="<?= get_field( 'donate', 'options' ) ?>" class="donate">Donate</a>
			</div>
		</div>
	</div>
</nav>
<header class="navigation" role="navigation" aria-label="<?php esc_attr_e( 'Navigation', 'twentysixteen' ); ?>">
	<div class="row header-row">
		<div class="col col-12 col-sm-9 page-title">
			<?php
			if( is_home() || is_singular( 'events' ) ):
				$page_title = 'Events';
				$page_url = home_url( '/' );
			elseif( is_post_type_archive( 'exhibitions' ) || is_singular( 'exhibitions' ) ):
				$page_title = 'Exhibitions';
				$page_url = get_permalink( get_page_by_path( 'exhibitions' )->ID );
			elseif( is_post_type_archive( 'partners' ) || is_singular( 'partners' ) ):
				$page_title = 'Partners';
				$page_url = get_permalink( get_page_by_path( 'partners' )->ID );
			elseif( is_post_type_archive( 'sponsors' ) || is_singular( 'sponsors' ) ):
				$page_title = 'Sponsors';
				$page_url = get_permalink( get_page_by_path( 'sponsors' )->ID );
			else:
				$page_title = get_the_title();
				$page_url = get_the_permalink();
			endif;
			if( $page_title == 'Events' ):
				echo '<div class="label desktop">Events</div>';
				echo '<div class="label mobile" onclick="void(0)">Filter events</div>';
			else:
				echo '<div class="label">'.$page_title.'</div>';
			endif;
			if( is_home() || $post->post_name == 'events' || is_singular( 'events' ) ): ?>
				<div class="toggles">
					<div class="desktop">
						<div class="toggle view active" data-view="grid">day view</div>
						<div class="toggle view" data-view="list">list view</div>
					</div>
					<div class="mobile">
						<?php 
						$event_types = get_terms( array(
							'taxonomy' => 'event_type',
							'hide_empty' => false,
						) );
						foreach( $event_types as $event_type ):
							echo '<div class="toggle filter active" data-filter="event-type" data-slug="'.$event_type->slug.'" onclick="void(0)">';
								echo $event_type->name;
							echo '</div>';
						endforeach;
						?>
						</br>
					</div>				
					<div class="toggle hide-past" onclick="void(0)">hide past events</div>
				</div>
			<?php elseif( is_singular( 'partners' ) || $post->post_name == 'partners' || $post->post_type == 'partners' ): ?>
				<div class="toggles">
					<?php
					$media_id = get_termx_by( 'slug', 'media', 'partner_type' );
					$partner_types = get_terms( array(
						'orderby' => 'term_order',
						'taxonomy' => 'partner_type',
						'hide_empty' => true,
						'exclude' => $media_id,
					) );
					foreach( $partner_types as $partner_type ):
						echo '<div class="toggle filter active" data-filter="partner-type" data-slug="'.$partner_type->slug.'" onclick="void(0)">';
							echo $partner_type->name;
						echo '</div>';
					endforeach;
					?>
				</div>
			<?php endif; ?>
		</div>

		<div class="col col-1 col-sm-3 site-title">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<div class="label"><?php bloginfo( 'name' ); ?></div>
			</a>
		</div>
	</div>
</header>
<!-- </div> -->