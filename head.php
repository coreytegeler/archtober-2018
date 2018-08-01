<?php $intro = str_replace( '[count]', $count, get_field( 'intro', 'option' ) ); ?>
<div id="intro"><?= $intro; ?></div>
<div class="header-wrap">
	<?php $count = 50; ?>
	<div class="header-placeholder">
		<div class="row"><div class="col col-12">
			<div>&nbsp;</div>
			<div class="views"><div class="view">&nbsp;</div></div>
		</div></div>
	</div>
	<header class="navigation" role="navigation" aria-label="<?php esc_attr_e( 'Navigation', 'twentysixteen' ); ?>">
		<div class="row header-row">
			<div class="col col-12 col-sm-6 page-title">
				<?php
				global $wp_query;
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
					echo '<div class="label mobile">Filter events</div>';
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
								echo '<div class="toggle filter active" data-filter="event-type" data-slug="'.$event_type->slug.'">';
									echo $event_type->name;
								echo '</div>';
							endforeach;
							?>
							</br>
						</div>				
						<div class="toggle hide-past">hide past events</div>
					</div>
				<?php elseif( $post->post_name == 'partners' ): ?>
					<div class="toggles">
						<?php
						$partner_types = get_terms( array(
							'orderby' => 'term_order',
						  'taxonomy' => 'partner_type',
						  'hide_empty' => true,
						) );
						foreach( $partner_types as $partner_type ):
							echo '<div class="toggle filter active" data-filter="partner-type" data-slug="'.$partner_type->slug.'">';
								echo $partner_type->name;
							echo '</div>';
						endforeach;
						?>
					</div>
				<?php endif; ?>
			</div>

			<div class="col col-1 col-sm-6 site-title">
				<div class="icon-btn burger"></div>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<div class="label"><?php bloginfo( 'name' ); ?></div>
				</a>
			</div>
		</div>
		<nav>
			<div class="icon-btn x"></div>
			<div class="row top">
				<div class="col col-12">
					<ul class="nav-menu">
						<?php
						$nav_items = wp_get_nav_menu_items( 'navigation' );
						foreach( $nav_items as $nav_item ):
							echo '<li class="menu-item"><a href="'.$nav_item->url.'">'.$nav_item->title.'</a></li>';
						endforeach;
						echo '<li class="menu-item archive">';
						echo '<span>Archive</span>';
						for( $year = 2017; $year >= 2011; $year-- ):
							echo '<a class="menu-item year" href="https://archtober.org/'.$year.'" target="_blank">'.$year.'</a>';
						endfor;
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
						<div class="pp">Privacy Policy</div>
						<div class="subscribe">Subscribe to Email</div>
					</div>
				</div>
			</div>
		</nav>

	</header>
</div>