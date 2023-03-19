<footer>
    <div class="footer-item">

        <h4>Kontakt info</h4>

        <a href="https://www.google.com/maps?q=+C.+R.+Jakobsoni+6,+10128+Tallinn,+Estonia" target="_blank">Jakobsoni 6</a>

        <a href="tel:+372 5014769">+372 5014769</a>

        <a href="tel:+372 58250366">Või +372 58250366</a>

        <a href="mailto:kellapandimaja@tkepandimaja.ee">kellapandimaja@tkepandimaja.ee</a>

        <br>

        <p>ONLINE hindamine 24/7</p>

        <p>Kontori lahtioleku ajad E-R 9-17</p>

        <br>
        <a href="/Privaatsustingimused/">Privaatsustingimused</a>
    </div>

    <div class="footer-item">
        <img src="<?= get_template_directory_uri(); ?>/img/kellapandimajalogo.png" alt="TKE Pandimaja Tallinn" width="192" height="192"/>
        <?= date("Y"); ?>
    </div>

    <div class="footer-item">

        <h4>Ettevõtte info</h4>
        <p>Esimene kella pandimaja Eestis</p>

        <p>TKE Pandimaja OÜ asutati AS Tallinna pank, Karavan
            OÜ ja E.P.T.A. OÜ poolt 1992 aastal sellest ka firma nimi TKE Pandimaja.
            Tänaseks on need juriidilised asutajaliikmed läinud igaüks
            oma teed, kuid juhtkond ja põhiline personal on säilinud.</p>

        <p>Iseenda arvates oleme andnud parima oma klientide
            teenendamisel. Kuid kindlasti on veel palju
            arengumaad. Ja need maad me püüame lähitulevikus okupeerida.</p>

    </div>

</footer>
<?php wp_footer(); ?>
</body>
</html>


<div class="footeroption">
    
     <div class="footeroption__item">
        <?php if (get_field('text_area', 'option')) : ?>
            <p><?php the_field('text_area', 'option'); ?>
            Kontakt info
            Jakobsoni 6
            +372 5014769
            Või +372 58250366
            kellapandimaja@tkepandimaja.ee

            ONLINE hindamine 24/7

            Kontori lahtioleku ajad E-R 9-17


            Privaatsustingimused
            </p>
        <?php endif; ?>

    </div>

     </div>

     <div class="footeroption__image">

         <?php if (get_field('image', 'option')) : ?>
             <img src="<?php the_field('image', 'option'); ?>" />
         <?php endif; ?>

     </div>

     <div class="footeroption__item">
         <?php
            if (get_field('title', 'option')) : ?>
             <h1> <?php the_field('title', 'option') ?></h1>
         <?php endif; ?>
         <?php
            if (get_field('text_area', 'option')) : ?>
             <p><?php the_field('text_area', 'option') ?></p>
         <?php endif; ?>

     </div>

 </div>