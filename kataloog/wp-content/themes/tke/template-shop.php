<?php

/*
Template Name: Shop Page
*/

 get_header('small'); ?>
<div id="main" class="row">
<div id="content" class="cartpage col-lg-12 col-sm-6 col-md-6 col-xs-12">
<h1>
<?php the_title(); ?>
</h1>




<?php if(have_posts()) : while(have_posts()) : the_post(); ?>
<?php the_content(); ?>
<?php endwhile; else: endif;?>
</div>
</div>
<?php get_footer(); ?>