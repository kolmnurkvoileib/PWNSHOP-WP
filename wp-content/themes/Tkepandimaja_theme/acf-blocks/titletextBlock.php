
<div id="Teave" style="
    margin: 20px auto;
    font-size: 1.5rem;
    text-decoration: underline;
    font-weight: 500;
    color: inherit;
    line-height: 1.2;
    font-family: inherit;">
    <?php
        if (get_field('title')) : ?>
            <?php the_field('title') ?>
    <?php endif; ?>
</div>

<div id="tekst">
    <?php
        if (get_field('text_area')) : ?>
            <?php the_field('text_area') ?>
    <?php endif; ?> 
</div>

