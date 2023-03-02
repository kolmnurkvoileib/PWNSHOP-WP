<?php get_header(); ?>
<div class="page-content">

    <div class="card-menu-page">

        <div class="card-menu-page__item">

            <div class="card-menu-page__item-inside">

                <h1>Briljantide kokkuostu tingimused</h1>
                <p>Kuidas leida pandimaja, kus võetakse briljante vastu kalli hinnaga? Tõenäoliselt peab see olema spetsialiseerunud
                    juveelipandimaja, kus töötavad sertifitseeritud gemmoloogid (spetsialistid vääriskivide alal). Ainult kogenud gemmoloogid
                    suudavad briljantidega ehteid objektiivselt hinnata. Sõrmuste, kõrvarõngaste, kaelakeede ja käevõrude kokkuostu korral
                    arvestatakse sellistes pandimajades lisaks esemete kaalule ka brändi tuntust,
                    disaini keerukust, mehaaniliste detailide korrasolekut.</p>
                <p>Ehetes olevate briljantide hindamisel võtame arvesse mitte ainult kivide, vaid
                    ka ehte valmistamiseks kasutatud väärismetalli väärtust. Tänu sellele garanteerime professionaalse ja tõesti ausa hindamise.
                    Selles on juba saanud veenduda kümned tuhanded Tallinna elanikud ja inimesed üle terve Eesti. </p>

                <p>Meie pandimajas tegutseb briljantide ja vääriskividega ehete online-hindamine. See toimub täiesti tasuta.
                    Teie lihtsalt saadate foto müüki antavast
                    briljandist ja meie spetsialist saadab teile 5-10 minuti pärast vastuseks esialgse hinna.</p>

                <p>Online-hindamine ei kohusta millekski. Kui hind teile ei meeldi, võite müügist
                    loobuda. Kuid me oleme valmis tegema Tallinna parima hinnapakkumise. </p>


                <div class="card-menu-page__item-buttons">
                    <button onclick="window.location='/e-hindamine/';"> E-HINDAMA <span class="tke-icon-menu-right"></button>
                    <button onclick="window.location='https://api.whatsapp.com/send?phone=3725014769';" class="whatsapp-button social-valutation"> Whatsapp Hindamine</button>
                    <button onclick="window.location='viber://add?number=3725014769';" class="viber-button social-valutation"> Viber Hindamine</button>
                </div>

            </div>

            <div class="card-menu-page__item-inside">

                <img src="<?= get_template_directory_uri(); ?>/img/kokkuostteenus.jpg"  alt="asjade kokkust" width="512" height="384"/>

            </div>

        </div>

        <div class="card-menu outside-page">

            <div class="card-menu__card" onclick="window.location='/muuk/';">
                <div class="card-menu__card-inside first-card">
                    <h3>MÜÜK</h3>
                </div>
            </div>

            <div class="card-menu__card" onclick="window.location='/pant/';">
                <div class="card-menu__card-inside second-card">
                    <h3>PANT</h3>
                </div>
            </div>


            <div class="card-menu__card" onclick="window.location='/kokkuost/';">
                <div class="card-menu__card-inside third-card">
                    <h3>KOKKUOST</h3>
                </div>
            </div>

            <div class="card-menu__card" onclick="window.location='/hindamine/';">
                <div class="card-menu__card-inside fourth-card">
                    <h3>HINDAMINE</h3>
                </div>
            </div>

        </div>

    </div>

</div>


</div>
<?php get_footer(); ?>