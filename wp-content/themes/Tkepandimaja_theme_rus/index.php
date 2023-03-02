<?php get_header(); ?>
<div class="page-content">
    <div class="card-menu">

        <div class="card-menu__card" onclick="window.location='/ru/muuk/';">
            <div class="card-menu__card-inside first-card">
                <h3>ПРОДАЖА</h3>
            </div>
        </div>

        <div class="card-menu__card" onclick="window.location='/ru/pant/';">
            <div class="card-menu__card-inside second-card">
                <h3>ЗАЛОГ</h3>
            </div>
        </div>


        <div class="card-menu__card" onclick="window.location='/ru/kokkuost/';">
            <div class="card-menu__card-inside third-card">
                <h3>СКУПКА</h3>
            </div>
        </div>

        <div class="card-menu__card" onclick="window.location='/ru/hindamine/';">
            <div class="card-menu__card-inside fourth-card">
                <h3>ОЦЕНКА</h3>
            </div>
        </div>

    </div>

    <div class="contact-free">

        <div class="contact-free__item">

            <img src="<?= get_template_directory_uri(); ?>/img/corona2.png" alt="Kontaktivaba pandimaja" width="500" height="500" />

            <h2>Если Вы желаете продлить договоры или осуществить возвратные платежи через банк, то перечислите необходимые суммы на наш банковский счёт в LHV банке: <br></h2>
            <h2> <br>EE777700771003683711<br><br></h2>
            <h2>Если Вы осуществили платёж, сообщите, пожалуйста, нам об этом по электронной почте или по телефону. Если Вы желаете выкупить свою вещь не приходя в наш офис, то и платёж за выкуп можете осуществить через банк, и мы вернём Вам вещь через посылочный автомат или по почте, но почтовые расходы несёт клиент. <br></h2>

        </div>

        <div class="contact-free__item">

            <h2>Бесконтактная сделка</h2>

            <ul>
                <li><img src="<?= get_template_directory_uri(); ?>/img/diamondicon.svg" alt="Juveelide pant" width="64" height="64" />Убедитесь, что вещь в наилучшем состоянии и чистая.</li>
                <li><img src="<?= get_template_directory_uri(); ?>/img/dokument.svg" alt="Usaldusväärne pandimaja" width="64" height="64" />Воспользуйтесь нашей онлайн-оценкой и оформите с нами договор.</li>
                <li><img src="<?= get_template_directory_uri(); ?>/img/kuller.svg" alt="kontaktivaba tehing" width="64" height="64" />Отправьте нам свою вещь через посылочный автомат или курьером.</li>
                <li><img src="<?= get_template_directory_uri(); ?>/img/luup.svg" alt="E-hindamine" width="64" height="64" />Ждите, пока мы проверим вещь.</li>
                <li><img src="<?= get_template_directory_uri(); ?>/img/euro.svg" alt="Teeni raha" width="64" height="64" />Получайте заработанные Вами деньги и радуйтесь!</li>
            </ul>

            <a href="/ru/pantimine/">Более подробную информацию о бесконтактной сделке найдёте здесь</a>

        </div>

    </div>

    <div class="online-valuation">

        <div class="online-valuation__section">

            <div class="online-valuation__item">

                <h1>ЧАСОВОЙ ЛОМБАРД</h1>

                <p>TKE ЛОМБАРД – это элитный часовой ломбард, расположенный в Москве Таллин и Санкт-Петербурге.
                     Находясь уже более 16 лет на рынке скупки, продажи, залога и оценки швейцарских часов и ювелирных 
                     украшений, мы заработали хорошую репутацию. 
                    Одно из наших основных преимуществ - лучшие условия по выдаче наличными: от 1000€ до 10 000€ всего за 15 минут.</p>

                <div class="online-valuation__item-images">

                    <div class="image-item">
                        <img src="<?= get_template_directory_uri(); ?>/img/kell.png" alt="Raha kiirelt" width="128" height="128" />
                        <h5>Быстро</h5>
                    </div>
                    <div class="image-item">
                        <img src="<?= get_template_directory_uri(); ?>/img/kott.png" alt="Hea hinnaga müük" width="128" height="128" />
                        <h5>Выгодно</h5>
                    </div>
                    <div class="image-item">
                        <img src="<?= get_template_directory_uri(); ?>/img/kilp.png" alt="Turvaline pandimaja" width="128" height="128" />
                        <h5>Безопасно</h5>
                    </div>
                    <div class="image-item">
                        <img src="<?= get_template_directory_uri(); ?>/img/kindel.png" alt="Privaatne pandimaja" width="128" height="128" />
                        <h5>Персонально</h5>
                    </div>

                </div>

                <button onclick="window.location='/ru/teenused/';">Подробнее <span class="tke-icon-menu-right"></span></button>

            </div>

            <div class="online-valuation__item">

                <img src="<?= get_template_directory_uri(); ?>/img/kohver.png" alt="Teeni raha" width="512" height="384" />

            </div>

        </div>

        <div class="online-valuation__section">

            <div class="online-valuation__item-wide">

                <h1>ONLINE-ОЦЕНКА</h1>
                <p>Узнайте стоимость своих драгоценностей за 15 минут</p>
                <p>Онлайн-оценка позволяет Вам быстро оценить драгоценности, не выходя из дома. 
                    Это сэкономит Ваше время и силы. Достаточно лишь заполнить заявку и приложить фотографии изделия.
                     После получения данных проводится оценка. Наш менеджер связывается с Вами, говорит примерную сумму, на которую 
                    Вы сможете рассчитывать в нашей компании, а также отвечает на все интересующие Вас вопросы.</p>


                <div class="online-valuation__buttons">
                  <button onclick="window.location='(/ru/e-hindamine/';"> Online Оценить <span class="tke-icon-menu-right"></button>
                    <button onclick="window.location='https://api.whatsapp.com/send?phone=3725014769';" class="whatsapp-button social-valutation"> Whatsapp Оценить</button>
                    <button onclick="window.location='viber://add?number=3725014769';" class="viber-button social-valutation"> Viber Оценить</button>
                </div>

            </div>

        </div>

    </div>

    <div class="front-page-information">

        <h1>Информация о ломбарде в Таллине</h1>

        <p>У нас, как и в банке, каждый желающий может получить денежные средства в кредит на выгодных условиях. 
            Основной плюс в том, что все операции производятся буквально за несколько минут. Вы можете взять ссуду 
            под залог часов либо продать их. Если же стоит вопрос продажи швейцарских часов, то без раздумий несите
             их к нам в ломбард – именно здесь их смогут адекватно оценить и предложить достойную сумму. Настоящему 
             эксперту, профессионалу с многолетним стажем работы, не составит труда отличить даже самую качественную 
             подделку от подлинника. Большинство экспертов подтверждают свои знания на сертификации. В ходе оценки изделия 
             экспертиза проводится независимо, объективно. Только настоящий мастер может достойным образом провести диагностику
              изделия, 
            установить его подлинность, а также, по определённым критериям, дать оценку состояния.</p>

    </div>
</div>
</div>
<?php get_footer(); ?>