<nav class="navigation" role="navigation" aria-label="<?php esc_attr_e( 'Navigation', 'twentysixteen' ); ?>">
	<ul>
		<li class="title">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				<h2 class="label"><?php bloginfo( 'name' ); ?></h2>
			</a>
			<!-- <div class="years"> -->
				<!-- <ol> -->
					<?#php for($year = 2017; $year >= 2011; $year--) {
						#echo '<li><h2><a href="https://archtober.org/'.$year.'" target="_blank">'.$year.'</a></h2></li>';
					#} ?>
				<!-- </ol> -->
			<!-- </div> -->
		</li>
		<?php if ( $sponsors_page = get_page_by_path('sponsors') ) { ?>
			<li class="sponsors">
				<a href="<?php echo get_the_permalink( $sponsors_page ); ?>" rel="sponsors">
					<h2 class="label">Sponsors</h2>
				</a>
			</li>
		<?php } ?>
		<!-- <li class="archive">
			<a><h2 class="label">Archive</h2></a>
		</li> -->
	</ul>
</nav>