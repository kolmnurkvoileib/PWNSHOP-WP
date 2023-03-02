<div class="pagecontent">
<?php
/**
* A Simple Category Template
*/
 
get_header(); ?> 
 
 <div class="blogposts">
 
 <?php 
// Check if there are any posts to display
if ( have_posts() ) : ?>
 
<header class="archive-header">
<h1 class="archive-title">  <?php 
        if (is_category()){
            echo 'Kategooria: ' . single_cat_title( '', false);
        }
    ?></h1></header>
 
 <?php endif; ?>
 <div class="blogitem a">
    <?php
$category_id = get_cat_ID(single_cat_title('', false));

	
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $args = array(
        'post_type' => 'post', // Your post type name
        'posts_per_page' => 15,
        'paged' => $paged,
		'cat'   => $category_id,
    );
    $loop = new WP_Query($args);
    if ($loop->have_posts()) {
        while ($loop->have_posts()) : $loop->the_post();
            ?>
     
        
            <?php get_template_part('kategooriajargi',get_post_format()); ?>
       
  
         <?php
        endwhile;
        $total_pages = $loop->max_num_pages;
        if ($total_pages > 1) {
            ?>
            <div class="pagination">
                <?php
                $current_page = max(1, get_query_var('paged'));
    
                echo paginate_links(array(
                    'base' => get_pagenum_link(1) . '%_%',
                    'format' => '/page/%#%',
                    'current' => $current_page,
                    'total' => $total_pages,
                    'prev_text' => __('<'),
                    'next_text' => __('>'),
					
                ));
                ?>
            </div>
						            <?php
        }
    }
    wp_reset_postdata();
    
	
	
	
    if (function_exists("pagination")) {
        pagination($wp_query->max_num_pages);
    }
    ?>
			
			  </div>

			  <div class="blogitem b">



<div class="kategooriatitle">

<h3>KATEGOORIAD</h3>

</div>
<div class="kategooriablogitem">
<?php

$categories = get_categories();
foreach($categories as $category) {
   echo '<div class="kategooriaitem"><a href="' . get_category_link($category->term_id) . '">' . $category->name . '</a></div>';
}
	?>
</div>
</div>
			  
  
    
    </div>

 </div>
<?php get_footer(); ?>