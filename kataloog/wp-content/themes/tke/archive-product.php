<?php

 get_header('small'); ?>
<div class="eshop_all">



<div class="eshop_front">

<h1 class="kategooriapagetitle">
<?php woocommerce_page_title(); ?>
</h1>

<div class="searchvark">
<?php 
echo do_shortcode( '[aws_search_form]' );
?>
</div>

<?php woocommerce_content(); ?>



<ul class="produktid">



<h1 class="kategooriatiitel">VIIMATI LISATUD TOOTED</h1>




    <?php
        $args = array( 'post_type' => 'product', 'posts_per_page' => 4, 'orderby' => 'rand' );
        $loop = new WP_Query( $args );
        while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>

            

                <li class="product fp">    

                    <a href="<?php echo get_permalink( $loop->post->ID ) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">

                        <?php woocommerce_show_product_sale_flash( $post, $product ); ?>

                        <?php if (has_post_thumbnail( $loop->post->ID )) echo get_the_post_thumbnail($loop->post->ID, 'shop_catalog'); else echo '<img src="'.woocommerce_placeholder_img_src().'" alt="Placeholder" width="300px" height="300px" />'; ?>

                        <h2><?php the_title(); ?></h2>

                        <span class="price"><?php echo $product->get_price_html(); ?></span>                    

                    </a>

                
                </li>
				

    <?php endwhile; ?>
	
	 
	
    <?php wp_reset_query(); ?>
</ul><!--/.products-->

</div>
</div>
</div>
<?php get_footer(); ?>