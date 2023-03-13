 <div class="textimageblock">

     <div class="textimageblock__item">
         <?php
            if (get_field('title')) : ?>
             <h1> <?php the_field('title') ?></h1>
         <?php endif; ?>
         <?php
            if (get_field('text_area')) : ?>
             <p><?php the_field('text_area') ?></p>
         <?php endif; ?>

     </div>

     <div class="textimageblock__image">

         <?php if (get_field('image')) : ?>
             <img src="<?php the_field('image'); ?>" />
         <?php endif; ?>

     </div>

 </div>