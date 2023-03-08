
<div id="Teave">
    <?php
        if (get_field('title')) : ?>
            <?php the_field('title') ?>
    <?php endif; ?>

    <br><br>

    <?php
        if (get_field('text_area')) : ?>
            <?php the_field('text_area') ?>
    <?php endif; ?>
<div>

<style>
    .Teave {
        margin-top: 5%;
    }
</style>