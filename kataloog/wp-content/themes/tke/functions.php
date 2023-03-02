<?php





require get_template_directory() . '/bootstrap-navwalker.php';



//PRORUCT GALLERY

add_action( 'after_setup_theme', 'yourtheme_setups' );
 
function yourtheme_setups() {
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
}


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

function customtheme_add_woocommerce_support()
 {
add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'customtheme_add_woocommerce_support' );


remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);


add_action('woocommerce_before_main_content', 'my_theme_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'my_theme_wrapper_end', 10);

function my_theme_wrapper_start() {
    echo '<section id="main">';
}

function my_theme_wrapper_end() {
    echo '</section>';
}

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
  
//sort by category

add_filter('woocommerce_default_catalog_orderby', 'misha_catalog_orderby_for_category');
 
function misha_catalog_orderby_for_category( $sort_by ) {
	if( !is_product_category('uncategorized') ) { 
		return $sort_by; // no changes for any page except Uncategorized
	}
	return 'date';
}





add_filter( 'woocommerce_product_subcategories_hide_empty', '__return_false' );


add_action( 'woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 5 );





remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 20 );





add_action( 'init', 'catalog_mode', 10 );

function catalog_mode() {

    remove_action( 'woocommerce_after_shop_loop_item'  , 'woocommerce_template_loop_add_to_cart'          , 10 );
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart'        , 30 );
    remove_action( 'woocommerce_simple_add_to_cart'    , 'woocommerce_simple_add_to_cart'                 , 30 );
    remove_action( 'woocommerce_grouped_add_to_cart'   , 'woocommerce_grouped_add_to_cart'                , 30 );
    remove_action( 'woocommerce_variable_add_to_cart'  , 'woocommerce_variable_add_to_cart'               , 30 );
    remove_action( 'woocommerce_external_add_to_cart'  , 'woocommerce_external_add_to_cart'               , 30 );
    remove_action( 'woocommerce_single_variation'      , 'woocommerce_single_variation'                   , 10 );
    remove_action( 'woocommerce_single_variation'      , 'woocommerce_single_variation_add_to_cart_button', 20 );

}


add_action( 'init', 'bbloomer_hide_price_add_cart_not_logged_in' );
  
function bbloomer_hide_price_add_cart_not_logged_in() {
   if ( ! is_user_logged_in() ) {
      remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
      remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
    
   }
}



  add_action( 'template_redirect', 'skip_cart_redirect' );
function skip_cart_redirect(){
    // Redirect to checkout (when cart is not empty)
    if ( ! WC()->cart->is_empty() && is_cart() ) {
        wp_safe_redirect( wc_get_checkout_url() ); 
        exit();
    }
    // Redirect to shop if cart is empty
    elseif ( WC()->cart->is_empty() && is_cart() ) {
        wp_safe_redirect( wc_get_page_permalink( 'shop' ) );
        exit();
    }
}




// remove the subcategories from the product loop
remove_filter( 'woocommerce_product_loop_start', 'woocommerce_maybe_show_product_subcategories' );

// add subcategories before the product loop (yet after catalog_ordering and result_count -> see priority 40)
add_action( 'woocommerce_before_shop_loop', 'wp56123_show_product_subcategories', 40 );

function wp56123_show_product_subcategories() {
    $subcategories = woocommerce_maybe_show_product_subcategories();
        if ($subcategories) {
          echo '<ul class="subcategories">',$subcategories,'</ul>';
    }
}



add_filter('gettext', 'translate_my_text' );
function translate_my_text($translated) {
    $translated = str_ireplace('Search results:', 'Otsingutulemused', $translated);
	 $translated = str_ireplace('Related products', 'Muud tooted', $translated);

    return $translated;
}
  
  
  
  
   /**
 Remove all possible fields
 **/
function wc_remove_checkout_fields( $fields ) {

    // Billing fields

    unset( $fields['billing']['billing_address_1'] );
    unset( $fields['billing']['billing_address_2'] );
    unset( $fields['billing']['billing_city'] );
	unset( $fields['billing']['billing_country'] );
    unset( $fields['billing']['billing_postcode'] );

    // Shipping fields
    unset( $fields['shipping']['shipping_company'] );
    unset( $fields['shipping']['shipping_phone'] );
    unset( $fields['shipping']['shipping_state'] );
    unset( $fields['shipping']['shipping_first_name'] );
    unset( $fields['shipping']['shipping_last_name'] );
    unset( $fields['shipping']['shipping_address_1'] );
    unset( $fields['shipping']['shipping_address_2'] );
    unset( $fields['shipping']['shipping_city'] );
    unset( $fields['shipping']['shipping_postcode'] );


    return $fields;
}
add_filter( 'woocommerce_checkout_fields', 'wc_remove_checkout_fields' );
?>