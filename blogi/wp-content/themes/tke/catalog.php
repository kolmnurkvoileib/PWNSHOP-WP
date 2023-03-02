<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  
  
    
  
  
  
  
  
    
    <?php if( has_post_thumbnail() ): ?>
    
      <div class="item a">
        <a href="<?php the_permalink()?>">
        <div class="thumbnail"><?php the_post_thumbnail('medium'); ?></div>
      </a>
      
  
      </div>
	  
	  
     <div class="item b">
      <?php the_title( sprintf('<h3 class="entry-title"><a href="%s">', esc_url( get_permalink() ) ),'</a></h3>' ); ?>
	  
	  
	  
	  <div class="kategooriad">
	  
	 <?php

$categories = get_the_category();
$separator = ' ';
$output = '';
if ( ! empty( $categories ) ) {
foreach( $categories as $category ) {
    $output .= '<div class="kategooriatags"><a href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="' . esc_attr( sprintf( __( 'View all posts in %s', 'textdomain' ), $category->name ) ) . '">' . esc_html( $category->name ) . '</a> </div>' . $separator;
}
echo trim( $output, $separator );
}
	?>
	  
	  <div class="kuupaev">
	<?php the_time('F jS, Y') ?>
	</div>
	 </div>
      
  <div class="postcontent">
         <?php

    $content = get_the_content();
    $trimmed_content = wp_trim_words( $content, 33, NULL );
    echo $trimmed_content;


?>
    
  </div>

 <div class="loeedasitag">
<a href="<?php the_permalink()?>">LOE EDASI...</a>
 </div>


</div>
  
    <?php else : ?>
    
          <?php the_title( sprintf('<h3 class="entry-title"><a href="%s">', esc_url( get_permalink() ) ),'</a></h3>' ); ?>
		  
		   <div class="kategooriad">
	 <?php

$categories = get_the_category();
$separator = ' ';
$output = '';
if ( ! empty( $categories ) ) {
foreach( $categories as $category ) {
    $output .= '<div class="kategooriatags"><a href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="' . esc_attr( sprintf( __( 'View all posts in %s', 'textdomain' ), $category->name ) ) . '">' . esc_html( $category->name ) . '</a> </div>' . $separator;
}
echo trim( $output, $separator );
}
	?>
	
	
	  <div class="kuupaev">
	<?php the_time('F jS, Y') ?>
	</div>
	
	 </div>
		  
      <div class="postcontent">
      <?php

    $content = get_the_content();
    $trimmed_content = wp_trim_words( $content, 33, NULL );
    echo $trimmed_content;


?>
     </div>


      <div class="loeedasitag">
<a href="<?php the_permalink()?>">LOE EDASI...</a>
 </div>
    
    <?php endif; ?>
  

</article>

