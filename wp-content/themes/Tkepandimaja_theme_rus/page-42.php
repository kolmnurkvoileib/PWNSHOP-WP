<?php get_header(); ?>
<div class="page-content">

    <div class="online-valutation-page">

        <div class="online-valutation-page__item">

            <h1>Элитный ломбард</h1>
            <h1>Узнайте стоимость своих драгоценностей за 15 минут</h1>

            <p>Часовой ломбард на Якобсони, 6 – один из ломбардов в Таллине, который
                 предлагает самые комфортные условия сотрудничества. Мы внимательно и
                  быстро произведём оценку изделия, предложив подходящую стоимость. Нигде
                   в столице Вы не найдёте таких цен при залоге часов или
                 ювелирных украшений в ломбард, у нас действительно высокая стоимость скупки.</p>

            <div class="online-valuation__buttons">
            <button onclick="window.location='https://api.whatsapp.com/send?phone=3725014769';" class="whatsapp-button social-valutation"> Whatsapp Оценить</button>
                    <button onclick="window.location='viber://add?number=3725014769';" class="viber-button social-valutation"> Viber Оценить</button>
            </div>

        </div>
        <div class="online-valutation-page__valutation">
            <?= do_shortcode('[contact-form-7 id="44" title="e-hindamine"]'); ?>
        </div>
    </div>
</div>
</div>
<?php get_footer(); ?>