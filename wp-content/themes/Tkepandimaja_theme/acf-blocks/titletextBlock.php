<div class="titletextblock">

<div class="titletext__title">
<?php
        if (get_field('title')) : ?>
            <h1><?php the_field('title') ?></h1>
    <?php endif; ?>

</div>

<div class="titletext__area">

<?php
        if (get_field('text_area')) : ?>
            <p><?php the_field('text_area') ?></p>
    <?php endif; ?> 

</div>

</div>