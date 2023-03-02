<?php
require get_template_directory() . '/bootstrap-navwalker.php';

//CUSTOM CSS AND JS

function keweb_script_enqueue() {
  
  $parent_style = 'parent-style'; 
  
  wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
  wp_enqueue_style( 'child-style',
  get_stylesheet_directory_uri() . '/style.css',
  array( $parent_style),
  wp_get_theme()->get('Version')
  );
  
  wp_enqueue_style('Bootstrap', get_template_directory_uri() . '/bootstrap/css/bootstrap.min.css', array(), '1.0.0', 'all');
  wp_enqueue_script('Bootstrap', get_template_directory_uri() . '/bootstrap/js/bootstrap.min.js', array(), '1.0.0', true);
  wp_enqueue_script('hover3d', get_template_directory_uri() . '/include/jquery.hover3d.min.js', array(), '1.0.0', true);
  
  wp_enqueue_script('custom', get_template_directory_uri() . '/js/keweb.js', array(), '1.0.0', true);
 
}

add_action( 'wp_enqueue_scripts', 'keweb_script_enqueue');

//MENUS

function keweb_theme_setup(){
add_theme_support('menus');
add_theme_support('post-thumbnails');
add_theme_support('post-formats',array('aside','image','video'));
register_nav_menu('primary', 'Primary Header Navigation');

}

add_action('init', 'keweb_theme_setup');



//Custom-Logo

add_theme_support( 'custom-logo');

add_filter('acf/settings/remove_wp_meta_box', '__return_false');
