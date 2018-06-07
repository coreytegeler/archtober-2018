<?php
$ver = '1.4';
function archtober_scripts() {
    wp_enqueue_style( 'style', get_stylesheet_uri() );
    wp_enqueue_script( 'jquery', get_template_directory_uri() . '/assets/js/jquery-3.3.1.min.js', array(), true );
    wp_enqueue_script( 'scripts', get_template_directory_uri() . '/assets/js/scripts.js', array(), $ver, true );
}
add_action( 'wp_enqueue_scripts', 'archtober_scripts' );

function register_events() {
  register_post_type( 'events',
    array(
      'labels' => array(
        'name' => __( 'Events' ),
        'singular_name' => __( 'Event' )
      ),
      'menu_position' => 2,
      'menu_icon' => 'dashicons-calendar-alt',
      'public' => true,
      'has_archive' => true,
      'supports' => array('title', 'thumbnail', 'editor', 'excerpt')
    )
  );
}
add_action( 'init', 'register_events' );

function register_sponsors() {
  register_post_type( 'sponsors',
    array(
      'labels' => array(
        'name' => __( 'Sponsors' ),
        'singular_name' => __( 'Sponsor' )
      ),
      'menu_position' => 2,
      'menu_icon' => 'dashicons-groups',
      'public' => true,
      'has_archive' => true,
      'supports' => array('title', 'thumbnail', 'editor')
    )
  );
}
add_action( 'init', 'register_sponsors' );

function remove_menus(){
  remove_menu_page( 'jetpack' );
  remove_menu_page( 'edit.php' );
  remove_menu_page( 'edit-comments.php' );
}
add_action( 'admin_menu', 'remove_menus' );

function register_navigation() {
  register_nav_menu( 'navigation', __( 'Navigation', 'theme-slug' ) );
}
add_action( 'after_setup_theme', 'register_navigation' );


if( function_exists('acf_add_options_page') ) {
  acf_add_options_page(); 
}
add_theme_support( 'post-thumbnails', array( 'post', 'page', 'events', 'sponsors' ) ); 
add_image_size( 'custom', 800, 533, true );
add_filter('show_admin_bar', 'false');
define( 'WP_DEBUG', true );
?>