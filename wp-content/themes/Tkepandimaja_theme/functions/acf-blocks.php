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
            'name'              => 'acf-block',
            'title'             => ('acf-block'),
            'description'       => __('acf-block.'),
            'render_template'   => 'acf-blocks/acf-block.php',
            'category'          => 'tkepandimaja',
            'icon'              => 'email',
            'keywords'          => array('acf-block'),
        ));

        acf_register_block_type(array(
            'name'              => 'acf-block-1',
            'title'             => ('acf-block-1'),
            'description'       => __('acf-block-1.'),
            'render_template'   => 'acf-blocks/acf-block-1.php',
            'category'          => 'tkepandimaja',
            'icon'              => 'email',
            'keywords'          => array('acf-block-1'),
        ));

        acf_register_block_type(array(
            'name'              => 'acf-block-2',
            'title'             => ('acf-block-2'),
            'description'       => __('acf-block-2.'),
            'render_template'   => 'acf-blocks/acf-block-2.php',
            'category'          => 'tkepandimaja',
            'icon'              => 'email',
            'keywords'          => array('acf-block-2'),
        ));

        acf_register_block_type(array(
            'name'              => 'acf-block-3',
            'title'             => ('acf-block-3'),
            'description'       => __('acf-block-3.'),
            'render_template'   => 'acf-blocks/acf-block-3.php',
            'category'          => 'tkepandimaja',
            'icon'              => 'email',
            'keywords'          => array('acf-block-3'),
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