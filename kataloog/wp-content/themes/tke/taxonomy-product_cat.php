<?php get_header('small'); ?>
<div class="eshop_all">
<div class="eshop_front kategooriatepage">


<h1 class="kategooriapagetitle">
<?php woocommerce_page_title(); ?>
</h1>


<div class="searchvark">
<?php 
echo do_shortcode( '[aws_search_form]' );
?>
</div>

<?php woocommerce_content(); ?>



</div>
</div>
<?php get_footer(); ?>