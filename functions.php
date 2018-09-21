<?php
function archtober_scripts() {
	$ver = '2.9.6';
	wp_enqueue_style( 'style', get_stylesheet_uri(), null, $ver );
	wp_enqueue_script( 'jquery', get_template_directory_uri() . '/assets/js/jquery-3.3.1.min.js', array(), true );
	wp_enqueue_script( 'imagesLoaded', get_template_directory_uri() . '/assets/js/imagesloaded.pkgd.min.js', array(), true );
	wp_enqueue_script( 'scripts', get_template_directory_uri() . '/assets/js/scripts.js', array(), $ver, true );
	wp_localize_script( 'scripts', 'ajax_obj', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
	));
}
add_action( 'wp_enqueue_scripts', 'archtober_scripts' );

add_action( 'wp_ajax_nopriv_get_overlay', 'get_overlay' );
add_action( 'wp_ajax_get_overlay', 'get_overlay' );

function get_overlay() {
	global $post; 
	$post = get_post( $_POST['id'] ); 
	$post_type = $_POST['post_type']; 
	setup_postdata($post);
	get_template_part( 'single', $post_type );
	die();
}


add_action( 'wp_ajax_nopriv_get_day_of_events', 'get_day_of_events' );
add_action( 'wp_ajax_get_day_of_events', 'get_day_of_events' );

function get_day_of_events() {
	$date_str = $_POST['date'];
	include( locate_template( 'loop-day.php' ) );
	die();
}

add_action( 'wp_ajax_nopriv_get_events_blocks', 'get_events_blocks' );
add_action( 'wp_ajax_get_events_blocks', 'get_events_blocks' );

function get_events_blocks() {
	get_template_part( 'loop', 'events-blocks' );
	die();
}

add_action( 'wp_ajax_nopriv_get_events_rows', 'get_events_rows' );
add_action( 'wp_ajax_get_events_rows', 'get_events_rows' );

function get_events_rows() {
	get_template_part( 'loop', 'events-rows' );
	die();
}

function add_query_vars_filter( $vars ) {
  $vars[] = 'event_types';
  $vars[] = 'event_date';
  return $vars;
}
add_filter( 'query_vars', 'add_query_vars_filter' );

function register_events() {
	register_post_type( 'events',
		array(
			'labels' => array(
				'name' => __( 'Events' ),
				'singular_name' => __( 'Event' )
			),
			'menu_position' => 4,
			'menu_icon' => 'dashicons-building',
			'public' => true,
			'has_archive' => true,
			'supports' => array('title', 'thumbnail', 'editor')
		)
	);
}
add_action( 'init', 'register_events' );

function register_event_types() {
	$event_type_args = array(
		'labels' => array(
			'name'              => _x( 'Event Types', 'taxonomy general name', 'textdomain' ),
			'singular_name'     => _x( 'Event Type', 'taxonomy singular name', 'textdomain' ),
			'search_items'      => __( 'Search Event Types', 'textdomain' ),
			'all_items'         => __( 'All Event Types', 'textdomain' ),
			'parent_item'       => __( 'Parent Event Type', 'textdomain' ),
			'parent_item_colon' => __( 'Parent Event Type:', 'textdomain' ),
			'edit_item'         => __( 'Edit Event Type', 'textdomain' ),
			'update_item'       => __( 'Update Event Type', 'textdomain' ),
			'add_new_item'      => __( 'Add New Event Type', 'textdomain' ),
			'new_item_name'     => __( 'New Event Type Name', 'textdomain' ),
			'menu_name'         => __( 'Event Types', 'textdomain' ),
		),
		'hierarchical' => true,
		'show_uri' => true,
		'show_admin_column' => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var' => true,
	);
	register_taxonomy( 'event_type', array( 'events' ), $event_type_args );
}
add_action( 'init', 'register_event_types' );

function register_time_of_day() {
	$time_of_day_args = array(
		'labels' => array(
			'name'              => _x( 'Times of Day', 'taxonomy general name', 'textdomain' ),
			'singular_name'     => _x( 'Time of Day', 'taxonomy singular name', 'textdomain' ),
			'search_items'      => __( 'Search Times of Day', 'textdomain' ),
			'all_items'         => __( 'All Times of Day', 'textdomain' ),
			'parent_item'       => __( 'Parent Time of Day', 'textdomain' ),
			'parent_item_colon' => __( 'Parent Time of Day:', 'textdomain' ),
			'edit_item'         => __( 'Edit Time of Day', 'textdomain' ),
			'update_item'       => __( 'Update Time of Day', 'textdomain' ),
			'add_new_item'      => __( 'Add New Time of Day', 'textdomain' ),
			'new_item_name'     => __( 'New Time of Day Name', 'textdomain' ),
			'menu_name'         => __( 'Times of Day', 'textdomain' ),
		),
		'hierarchical' => true,
		'show_uri' => true,
		'show_admin_column' => false,
		'update_count_callback' => '_update_post_term_count',
		'query_var' => true,
	);
	register_taxonomy( 'time_of_day', array( 'events' ), $time_of_day_args );
}
add_action( 'init', 'register_time_of_day' );

function register_exhibitions() {
	register_post_type( 'exhibitions',
		array(
			'labels' => array(
				'name' => __( 'Exhibitions' ),
				'singular_name' => __( 'Exhibition' )
			),
			'menu_position' => 5,
			'menu_icon' => 'dashicons-calendar-alt',
			'public' => true,
			'has_archive' => true,
			'supports' => array('title', 'thumbnail', 'editor')
		)
	);
}
add_action( 'init', 'register_exhibitions' );

function register_institutions() {
	$institution_args = array(
		'labels' => array(
			'name'              => _x( 'Institutions', 'taxonomy general name', 'textdomain' ),
			'singular_name'     => _x( 'Institution', 'taxonomy singular name', 'textdomain' ),
			'search_items'      => __( 'Search Institutions', 'textdomain' ),
			'all_items'         => __( 'All Institutions', 'textdomain' ),
			'parent_item'       => __( 'Parent Institution', 'textdomain' ),
			'parent_item_colon' => __( 'Parent Institution:', 'textdomain' ),
			'edit_item'         => __( 'Edit Institution', 'textdomain' ),
			'update_item'       => __( 'Update Institution', 'textdomain' ),
			'add_new_item'      => __( 'Add New Institution', 'textdomain' ),
			'new_item_name'     => __( 'New Institution Name', 'textdomain' ),
			'menu_name'         => __( 'Institutions', 'textdomain' ),
		),
		'hierarchical' => true,
		'show_uri' => true,
		'show_admin_column' => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var' => true,
	);
	register_taxonomy( 'institution', array( 'exhibitions' ), $institution_args );
}
add_action( 'init', 'register_institutions' );


function register_sponsors() {
	register_post_type( 'sponsors',
		array(
			'labels' => array(
				'name' => __( 'Sponsors' ),
				'singular_name' => __( 'Sponsor' )
			),
			'menu_position' => 6,
			'menu_icon' => 'dashicons-universal-access',
			'public' => true,
			'has_archive' => true,
			'supports' => array('title', 'thumbnail', 'editor')
		)
	);
}
add_action( 'init', 'register_sponsors' );

function register_sponsor_types() {
	$sponsor_type_args = array(
		'labels' => array(
			'name'              => _x( 'Sponsor Types', 'taxonomy general name', 'textdomain' ),
			'singular_name'     => _x( 'Sponsor Type', 'taxonomy singular name', 'textdomain' ),
			'search_items'      => __( 'Search Sponsor Types', 'textdomain' ),
			'all_items'         => __( 'All Sponsor Types', 'textdomain' ),
			'parent_item'       => __( 'Parent Sponsor Type', 'textdomain' ),
			'parent_item_colon' => __( 'Parent Sponsor Type:', 'textdomain' ),
			'edit_item'         => __( 'Edit Sponsor Type', 'textdomain' ),
			'update_item'       => __( 'Update Sponsor Type', 'textdomain' ),
			'add_new_item'      => __( 'Add New Sponsor Type', 'textdomain' ),
			'new_item_name'     => __( 'New Sponsor Type Name', 'textdomain' ),
			'menu_name'         => __( 'Sponsor Types', 'textdomain' ),
		),
		'hierarchical' => true,
		'show_uri' => true,
		'show_admin_column' => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var' => true,
	);
	register_taxonomy( 'sponsor_type', array( 'sponsors' ), $sponsor_type_args );
}
add_action( 'init', 'register_sponsor_types' );

function register_partners() {
	register_post_type( 'partners',
		array(
			'labels' => array(
				'name' => __( 'Partners' ),
				'singular_name' => __( 'Partner' )
			),
			'menu_position' => 7,
			'menu_icon' => 'dashicons-universal-access-alt',
			'public' => true,
			'has_archive' => true,
			'supports' => array('title', 'thumbnail', 'editor')
		)
	);
}
add_action( 'init', 'register_partners' );

function register_partner_types() {
	$partner_type_args = array(
		'labels' => array(
			'name'              => _x( 'Partner Types', 'taxonomy general name', 'textdomain' ),
			'singular_name'     => _x( 'Partner Type', 'taxonomy singular name', 'textdomain' ),
			'search_items'      => __( 'Search Partner Types', 'textdomain' ),
			'all_items'         => __( 'All Partner Types', 'textdomain' ),
			'parent_item'       => __( 'Parent Partner Type', 'textdomain' ),
			'parent_item_colon' => __( 'Parent Partner Type:', 'textdomain' ),
			'edit_item'         => __( 'Edit Partner Type', 'textdomain' ),
			'update_item'       => __( 'Update Partner Type', 'textdomain' ),
			'add_new_item'      => __( 'Add New Partner Type', 'textdomain' ),
			'new_item_name'     => __( 'New Partner Type Name', 'textdomain' ),
			'menu_name'         => __( 'Partner Types', 'textdomain' ),
		),
		'hierarchical' => true,
		'show_uri' => true,
		'show_admin_column' => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var' => true,
	);
	register_taxonomy( 'partner_type', array( 'partners' ), $partner_type_args );
}
add_action( 'init', 'register_partner_types' );


function admin_column_date_order( $wp_query ) {
	global $pagenow;
		if ( is_admin() && 'edit.php' == $pagenow && !isset( $_GET['orderby'] )) {
			$screen = get_current_screen();
			$post_type = $screen->post_type;
			if( $post_type == 'events' ):
				$wp_query->set( 'order', 'DESC' );
				$wp_query->set( 'meta_key', 'date' );
				$wp_query->set( 'orderby',  'meta_value_num' );
			elseif( $post_type == 'exhibitions' ):
				$wp_query->set( 'order', 'DESC' );
				$wp_query->set( 'meta_key', 'start_date' );
				$wp_query->set( 'orderby',  'meta_value_num' );
			endif;
		}
}
add_filter('pre_get_posts', 'admin_column_date_order' );


function add_events_columns( $columns ) {
	unset( $columns['date'] );
	return array_merge( $columns, array(
		'start_date' => __( 'Start Date' ),
		'partners' => __( 'Partners' ),
	) );
}
add_filter('manage_events_posts_columns' , 'add_events_columns');

function add_exhibitions_columns( $columns ) {
	unset( $columns['date'] );
	return array_merge( $columns, array(
		'start_date' => __( 'Start Date' ),
	) );
}
add_filter('manage_exhibitions_posts_columns' , 'add_exhibitions_columns');

function custom_events_column( $column, $post_id ) {
	switch ( $column ) {
		case 'start_date':
			$start_date = get_post_meta( $post_id, 'date' , true );
			if($start_date && $start_date != 'Invalid date'):
				$start_date = new DateTime( $start_date );
				echo $start_date->format('m/j/y');
			else:
				echo '';
			endif;
			break;
		case 'partners':
			$partners = get_field( 'partner', $post_id );
			foreach( $partners as $partner ):
				$partner = get_post( $partner );
				if( $partner->post_type == 'partners' ):
					echo $partner->post_title;
				endif;
			endforeach;
			break;
	}
}
add_action( 'manage_events_posts_custom_column' , 'custom_events_column', 10, 2 );

function custom_exhibitions_column( $column, $post_id ) {
	switch ( $column ) {
		case 'start_date':
			$start_date = get_post_meta( $post_id, 'start_date' , true );
			if($start_date && $start_date != 'Invalid date'):
				$start_date = new DateTime( $start_date );
				echo $start_date->format('m/j/y');
			else:
				echo '';
			endif;
			break;
	}
}
add_action( 'manage_exhibitions_posts_custom_column' , 'custom_exhibitions_column', 10, 2 );


function register_events_sortable_columns( $columns ) {
	$columns['start_date'] = 'start_date';
	$columns['partners'] = 'partners';
	return $columns;
}
add_filter( 'manage_edit-events_sortable_columns', 'register_events_sortable_columns' );

function register_exhibitions_sortable_columns( $columns ) {
	$columns['start_date'] = 'start_date';
	return $columns;
}
add_filter( 'manage_edit-exhibitions_sortable_columns', 'register_exhibitions_sortable_columns' );

function custom_column_orderby( $vars ) {
	if( isset( $vars['orderby'] ) ):
		if( $vars['orderby'] == 'start_date' ):
			if( $vars['post_type'] == 'events' ):
				$meta_key = 'date';
			elseif( $vars['post_type'] == 'exhibitions' ):
				$meta_key = 'start_date';
			endif;
			$vars = array_merge( $vars, array(
				'meta_key' => $meta_key,
				'orderby' => 'meta_value_num'
			) );
		endif;
		if( isset($vars['order'] ) ):
			$vars = array_merge( $vars, array (
				'order' => $vars['order']
			) );
		endif;
	endif;
	return $vars;
}
add_filter( 'request', 'custom_column_orderby' );


function remove_menus(){
	remove_menu_page( 'jetpack' );
	remove_menu_page( 'edit-comments.php' );
}
add_action( 'admin_menu', 'remove_menus' );

function register_navigation() {
	register_nav_menu( 'navigation', __( 'Navigation', 'theme-slug' ) );
}
add_action( 'after_setup_theme', 'register_navigation' );


function get_time_span( $post_id ) {
	$time_span = '';
	if( have_rows( 'times', $post_id ) ):
		while( have_rows( 'times', $post_id ) ): the_row();
			$start_time = get_sub_field( 'start_time' );
			$end_time = get_sub_field( 'end_time' );
			if( $start_time ):
				if( get_row_index() > 1 ):
					$time_span .= ', ';
				endif;

				if( $end_time ):
					$pseudo_start_date = date_create( '2018-10-01 '.$start_time );
					$pseudo_end_date = date_create( '2018-10-01 '.$end_time );
					$start_period = date_format( $pseudo_start_date, 'a' );
					$end_period = date_format( $pseudo_end_date, 'a' );
					if( $start_period == $end_period ):
						$start_time = str_replace( $start_period, '', $start_time );
					endif;
				endif;

				$time_span .= $start_time;
				if( $end_time ):
					$time_span .= '&ndash;'.$end_time;
				endif;
			endif;
		endwhile;
	endif;
	$time_span = str_replace( ':00', '', $time_span );
	return $time_span;
}

function get_event_types( $post_id ) {
	$types = get_the_terms( $post_id, 'event_type' );
	$types_html = ''; 
	if( $types ):
		foreach( $types as $type ):
			$types_html .= '<span>'.$type->name.'</span>';
		endforeach;
	endif;
	return $types_html;
}

function get_terms_str( $post_id, $taxonomy ) {
	$terms = wp_get_post_terms( $post_id, $taxonomy );
	$arr = array();
	foreach( $terms as $obj ){
		array_push( $arr, $obj->slug );
	}
	$str = implode( ',', $arr );
	return $str;
}

function pretty_url( $url ) {
	$url = http($url);
	$url = parse_url($url);
	$url = $url['host'];
	$url = preg_replace( '#^www1\.(.+\.)#i', '$1', $url );
	$url = preg_replace( '#^www\.(.+\.)#i', '$1', $url );
	return $url;
}

function http($url) {
	if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
			$url = "http://" . $url;
	}
	return $url;
}

if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(); 
}
add_theme_support( 'post-thumbnails', array( 'post', 'page', 'events', 'sponsors', 'exhibitions' ) );
add_image_size( 'custom', 800, 533, true );

add_filter( 'show_admin_bar', '__return_false' );
?>