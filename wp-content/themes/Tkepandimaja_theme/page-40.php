<?php get_header(); ?>
<div class="page-content">

    <div class="card-menu-page">

        <div class="card-menu-page__item">

            <div class="card-menu-page__item-inside">

                <h1>Hindame vääriliselt</h1>
                <p>Hindamine meie spetsialistide poolt on täiesti tasuta ja võtab kõigest mõne minuti.
                    Hindame selliseid esemeid nagu eliitkellad, juveelid, aksessuaarid
                    ja lihvitud vääriskivid massiga alates 1 karaadist. Pärast hindamist teeme soodsa ostupakkumise.</p>
                <p>Meie pandimaja on hea koht, kuhu ära anda mittevajalikuks muutunud väärismetallist ehted, esemed
                    ja suveniirid ning täiendada niiviisi isiklikku või perekonna eelarvet. Ostame esemeid soodsa kursiga
                    ja määrame hinna asjatundlikult. Selleks aga, et teada saada, kui väärtusliku esemega on tegu ja kui suurel määral
                    see teie eelarvet täiendab, ei pea te isegi kodunt väljuma – meie pandimajas töötab online-hindamine.</p>

                <p>Kui ese on hindamise tulemuste põhjal kallim kui 500 eurot, ei pea te pandimajja tulema.
                    Meie ostuspetsialist võib teie juurde koju või kontorisse tulla. Kui aga soovite konfidentsiaalsust ja
                    turvalisust säilitada, võime kohtuda kohvikus, kaubanduskeskuses või mõnel muul neutraalsel pinnal. </p>

                <p>Online-hindamise viivad läbi samad spetsialistid, kes «elusast peastki» ja tänu sellele on see sama täpne.
                    Protseduur ise võtab tavaliselt aega mõne minuti. Hindamine on tasuta – seega, kui hind teid ei rahulda,
                    ei ole te kohustatud eset
                    müüma. Kuna aga pakume Tallinna ja terve Eesti parimaid hindu, peaks hind teid rõõmustama!</p>


                <div class="card-menu-page__item-buttons">
                    <button onclick="window.location='/e-hindamine/';"> E-HINDAMA <span class="tke-icon-menu-right"></button>
                    <button onclick="window.location='https://api.whatsapp.com/send?phone=3725014769';" class="whatsapp-button social-valutation"> Whatsapp Hindamine</button>
                    <button onclick="window.location='viber://add?number=3725014769';" class="viber-button social-valutation"> Viber Hindamine</button>
                </div>

            </div>

            <div class="card-menu-page__item-inside">
                <img src="<?= get_template_directory_uri(); ?>/img/hindamineteenus.jpg" alt="Esemete hindamine" width="512" height="384"/>
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