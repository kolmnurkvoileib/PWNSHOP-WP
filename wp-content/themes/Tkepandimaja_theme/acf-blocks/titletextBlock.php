
<div class="teave">
    <?php
        if (get_field('title')) : ?>
            <?php the_field('title') ?>
    <?php endif; ?>
</div>

<div class="tekst">
    <?php
        if (get_field('text_area')) : ?>
            <?php the_field('text_area') ?>
    <?php endif; ?> 
</div>

