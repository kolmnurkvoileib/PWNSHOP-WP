<div id="eliitpandimaja">
    <?php
        if (get_field('title')) : ?>
            <?php the_field('title') ?>
    <?php endif; ?>
</div>

    <br>

<div id="section1">
    <?php
        if (get_field('text_area')) : ?>
            <?php the_field('text_area') ?>
    <?php endif; ?>
</div>

    <br>

<div id="kellapilt">
    <?php if( get_field('image') ): ?>
        <img src="<?php the_field('image'); ?>" />
    <?php endif; ?>
<div>

    <br>

<style>

</style>



