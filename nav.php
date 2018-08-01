<header class="navigation" role="navigation" aria-label="<?php esc_attr_e( 'Navigation', 'twentysixteen' ); ?>">
	<div class="row">
		<div class="col col-6 page-title">

		</div>

		<div class="col col-6 site-title">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<h2 class="label"><?php bloginfo( 'name' ); ?></h2>
			</a>
		</div>

	</div>

	<nav>
		<ul class="nav-menu">

			<?php if ( $events_page = get_page_by_path('events') ) { ?>
				<li><a href="<?php echo get_the_permalink( $events_page ); ?>" rel="events">
					<h2 class="label">Events</h2>
				</a></li>
			<?php } ?>

			<?php if ( $about_page = get_page_by_path('about') ) { ?>
				<li><a href="<?php echo get_the_permalink( $about_page ); ?>" rel="about">
					<h2 class="label">About</h2>
				</a></li>
			<?php } ?>

			<?php if ( $participants_page = get_page_by_path('participants') ) { ?>
				<li><a href="<?php echo get_the_permalink( $participants_page ); ?>" rel="participants">
					<h2 class="label">Participants</h2>
				</a></li>
			<?php } ?>

			<?php if ( $sponsors_page = get_page_by_path('sponsors') ) { ?>
				<li><a href="<?php echo get_the_permalink( $sponsors_page ); ?>" rel="sponsors">
					<h2 class="label">Sponsors</h2>
				</a></li>
			<?php } ?>

			<li class="archive">
				<h2 class="label">Archive</h2>
					<?php for($year = 2017; $year >= 2011; $year--) {
						echo '<h2 class="year"><a href="https://archtober.org/'.$year.'" target="_blank">'.$year.'</a></h2>';
					} ?>
			</li>

		</ul>
	</nav>
</header>