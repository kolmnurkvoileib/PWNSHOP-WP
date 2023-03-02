<?php get_header(); ?>
<div class="page-content">

    <div class="card-menu-page">

        <div class="card-menu-page__item">

            <div class="card-menu-page__item-inside">

                <h1>Müü kallilt Šveitsi kell</h1>
                <p>Šveitsi brändide kellasid saab müüa kõige soodsamalt ja turvalisemalt
                    kelladele spetsialiseerunud pandimajas.
                    Tuntuimaks juveelisuuna pandimajaks Eestis on TKE Pandimaja.</p>
                <p>Šveitsi kellad maksavad müügi korral alati rohkem kui ostuhetkel.
                    Peaasi on pöörduda õige ostja poole, kelle spetsialistid suudavad eksemplari maksumust õigesti hinnata.</p>
                <p>Paljudes pandimajades näiteks ostetakse ainult väärismetallist – kullast, plaatinast ja
                    hõbedast korpuses Šveitsi kelli ja hindamine toimub seejuures mõistagi ainult kaalu järgi.
                    See on Šveitsi kella omaniku jaoks arusaadavalt
                    kõige ebasoodsam müügiviis. Ületab ju eksemplari koguväärtus tihtipeale kümneid (!) kordi väärismetalli väärtust. </p>

                <p>Näiteks kullast korpuses (proov 375) kell Longines L5 kaalub kõigest umbes
                    10 grammi. Seetõttu pakub enamus pandimaju selle eest ligikaudu 200 eurot. Meie aga oleme nende Šveitsi kella eriti
                    haruldaste modifikatsioonide eest valmis maksma kuni 3000 eurot. Tulu on ilmne, kas pole? </p>

                <div class="card-menu-page__item-buttons">
                    <button onclick="window.location='/e-hindamine/';"> E-HINDAMA <span class="tke-icon-menu-right"></button>
                    <button onclick="window.location='https://api.whatsapp.com/send?phone=3725014769';" class="whatsapp-button social-valutation"> Whatsapp Hindamine</button>
                    <button onclick="window.location='viber://add?number=3725014769';" class="viber-button social-valutation"> Viber Hindamine</button>
                </div>

            </div>

            <div class="card-menu-page__item-inside">

                <img src="<?= get_template_directory_uri(); ?>/img/kellamuuk.jpg"  alt="Kellade kokkuost" width="512" height="384"/>

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