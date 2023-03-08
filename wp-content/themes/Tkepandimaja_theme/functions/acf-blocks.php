<?php

function tkepandimaja_block_categories($categories, $post)
{
    $categories[] = [
        'slug' => 'tkepandimaja',
        'title' => __('tkepandimaja', 'tkepandimaja')
    ];

    return array_reverse($categories);
}
add_filter('block_categories', 'tkepandimaja_block_categories', 1, 2);

add_action('acf/init', 'my_acf_init_block_types');
function my_acf_init_block_types()
{


    if (function_exists('acf_register_block_type')) {

        acf_register_block_type(array(
            'name'              => 'textimageBlock',
            'title'             => ('textimageBlock'),
            'description'       => __('textimageBlock.'),
            'render_template'   => 'acf-blocks/textimageBlock.php',
            'category'          => 'tkepandimaja',
            'icon'              => 'email',
            'keywords'          => array('textimageBlock'),
        ));

        acf_register_block_type(array(
            'name'              => 'titletextBlock',
            'title'             => ('titletextBlock'),
            'description'       => __('titletextBlock.'),
            'render_template'   => 'acf-blocks/titletextBlock.php',
            'category'          => 'tkepandimaja',
            'icon'              => 'email',
            'keywords'          => array('titletextBlock'),
        ));

        acf_register_block_type(array(
            'name'              => 'repeaterBlock',
            'title'             => ('repeaterBlock'),
            'description'       => __('repeaterBlock.'),
            'render_template'   => 'acf-blocks/repeaterBlock.php',
            'category'          => 'tkepandimaja',
            'icon'              => 'email',
            'keywords'          => array('repeaterBlock'),
        ));
    }

        
}

//See osa optionitele mida pärast kasutame ei ole seotud blokkidega

if (function_exists('acf_add_options_page')) {

    acf_add_options_page(array(
        'page_title'     => 'Theme Settings',
        'menu_title'    => 'Theme Settings',
        'menu_slug'     => 'theme-settings',
        'capability'    => 'edit_posts',
        'redirect'        => false
    ));

    acf_add_options_sub_page(array(
        'page_title'     => 'Theme Footer',
        'menu_title'    => 'Footer',
        'parent_slug'    => 'theme-settings',
    ));
}

?>