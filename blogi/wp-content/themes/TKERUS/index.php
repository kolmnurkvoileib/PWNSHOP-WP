<div class="pagecontent">
<?php get_header(); ?>


<div class="blogposts">

<div class="blogitem a">

		
		
<?php
if ( get_query_var('paged') ) { $paged = get_query_var('paged'); }
elseif ( get_query_var('page') ) { $paged = get_query_var('page'); }
else { $paged = 1; }

query_posts(array(
    'post_type'      => 'post', // You can add a custom post type if you like
    'paged'          => $paged,
    'posts_per_page' => 10
));

if ( have_posts() ) : ?>

<?php while ( have_posts() ) : the_post(); ?>

    <?php get_template_part('catalog',get_post_format()); ?>

<?php endwhile; ?>


<div class="pagination">
    <?php my_pagination(); ?>
	</div>

<?php else : ?>

    <?php 
echo '<h3>В блоге нету постов</h3>' ?>
<?php wp_reset_query(); // add this ?>
<?php endif; ?>



</div>

<div class="blogitem b">



<div class="kategooriatitle">

<h3>
категория</h3>

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