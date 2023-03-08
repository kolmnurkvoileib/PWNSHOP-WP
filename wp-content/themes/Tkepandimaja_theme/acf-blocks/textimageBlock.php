   
   <div id="tiitel">
        <?php
                if (get_field('title')) : ?>
                    <?php the_field('title') ?>
            <?php endif; ?>
    </div>


    
    <?php
        if (get_field('text_area')) : ?>
            <?php the_field('text_area') ?>
    <?php endif; ?>


    
    <?php if( get_field('image') ): ?>
        <img src="<?php the_field('image'); ?>" />
    <?php endif; ?>

    <br>



