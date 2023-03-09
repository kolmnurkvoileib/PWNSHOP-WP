   
   <div id="tiitel" style="
   margin-bottom: 0.5rem;
   font-family: inherit;
   font-weight: 500;
   line-height: 1.2;
   color: inherit;
   font-size: 1.6rem;
   text-decoration: underline;">
        <?php
                if (get_field('title')) : ?>
                    <?php the_field('title') ?>
            <?php endif; ?>
    </div>


    <div id="eliitpandimaja" style="
    display: inline-block;
    width: 50%;">
        <?php
            if (get_field('text_area')) : ?>
                <?php the_field('text_area') ?>
        <?php endif; ?>
    </div>

    <div id="pilt" style="
    display: inline-flex;">
        <?php if( get_field('image') ): ?>
            <img src="<?php the_field('image'); ?>" />
        <?php endif; ?>
    </div>


