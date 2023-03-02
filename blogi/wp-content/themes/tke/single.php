
	
<div class="pagecontent">

<?php get_header(); ?>


	
<div class="blogposts single">
	
  

    <?php if( has_post_thumbnail() ): ?>
    <div class="blogitem a"> 
       <?php the_title( sprintf('<h3 class="entry-title"><a href="%s">', esc_url( get_permalink() ) ),'</a></h3>' ); ?>
        <a href="<?php the_permalink()?>">
        <div class="thumbnail"><?php the_post_thumbnail('large'); ?></div>
      </a>
      
  
     
     <div class="singlecontent">  
     
      <?php

    $content = get_the_content();
  
    echo $content;


?>

</div>
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


    <?php else: ?>
   


	
<div class="blogitem a">  


      
 


    
       <?php the_title( sprintf('<h3 class="entry-title"><a href="%s">', esc_url( get_permalink() ) ),'</a></h3>' ); ?>
        <a href="<?php the_permalink()?>">
        <div class="thumbnail"><?php the_post_thumbnail('large'); ?></div>
      </a>
      
  
     
     <div class="singlecontent">  
     
      <?php

    $content = get_the_content();
  
    echo $content;


?>

</div>
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


    <?php endif; ?>


<?php get_footer(); ?>
