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


//Custom-Header

$defaults = array(
  'default-image'          => '/img/oleviste.jpg',
  'width'                  => 2400,
  'height'                 => 1000,
  'flex-height'            => false,
  'flex-width'             => false,
  'uploads'                => true,
  'random-default'         => false,
  'header-text'            => true,
);
add_theme_support( 'custom-header', $defaults );

//Custom-Logo

add_theme_support( 'custom-logo');

add_filter('acf/settings/remove_wp_meta_box', '__return_false');





  
/**
* Pagination
*
* @param int $pages number of pages.
* @param int $range number of links to show of lest and right from current post.
*
* @return html Returns the pagination html block.
*/

if ( ! function_exists( 'my_pagination' ) ) :
    function my_pagination() {
        global $wp_query;

        $big = 999999999; // need an unlikely integer

        echo paginate_links( array(
            'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'format' => '?paged=%#%',
            'current' => max( 1, get_query_var('paged') ),
			'prev_text' => __('« Eelmised'),
                        'next_text' => __('Järgmised »'),
            'total' => $wp_query->max_num_pages

        ) );
    }
endif;



function custom_posts_per_page( $query ) {

if ( $query->is_archive('project') ) {
    set_query_var('posts_per_page', -1);
}
}
add_action( 'pre_get_posts', 'custom_posts_per_page' );







  
?>