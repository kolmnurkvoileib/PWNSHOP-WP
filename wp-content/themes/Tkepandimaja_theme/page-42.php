<?php get_header(); ?>
<div class="page-content">

    <div class="online-valutation-page">

        <div class="online-valutation-page__item">

            <h1>VEEBIHINDAMINE</h1>
            <h1>Oma väärisasjade maksumuse saate teada 15 minutiga</h1>

            <p>Kellade pandimaja Jakobsoni 6 on mugavamaid koostöötingimusi
                pakkuv Tallinna pandimaja. Hindame eseme tähelepanelikult ja kiiresti ning pakume sobiva hinna.
                Kella või juveele pandimajja panti andes ei leia Teie pealinnas
                mitte kusagilt mujalt selliseid hindu, sest meil on tõepoolest kõrge kokkuostuhind.</p>

            <div class="online-valuation__buttons">
                <button onclick="window.location='https://api.whatsapp.com/send?phone=3725014769';" class="whatsapp-button social-valutation"> Whatsapp Hindamine</button>
                <button onclick="window.location='viber://add?number=3725014769';" class="viber-button social-valutation"> Viber Hindamine</button>
            </div>

        </div>
        <div class="online-valutation-page__valutation">
            <?= do_shortcode('[contact-form-7 id="44" title="e-hindamine"]'); ?>
        </div>
    </div>
</div>
</div>
<?php get_footer(); ?>