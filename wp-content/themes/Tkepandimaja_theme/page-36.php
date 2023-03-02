<?php get_header(); ?>
<div class="page-content">

    <div class="card-menu-page">

        <div class="card-menu-page__item">

            <div class="card-menu-page__item-inside">

                <h1>Pantimise eelised</h1>
                <p>Teenuse tähendust mõistab igaüks, kellel on kunagi tekkinud vajadusi leida kiirest suur rahasumma.
                    Eriti kui on tegemist töövälise ja piiratud ajaga. Raske on leida alternatiivi sellisele mugavale
                    raha saamise võimalusele, nagu seda on kella pantimine pandimajas. Kellade pandimaja Jakobsoni 6 võtab vastu järgmisi
                    eliitkaubamärgiga kasutatud Šveitsi kellasid: Carl F. Bucherer, A. Lange & Söhne, Alain Silberstein, Audemars Piguet,
                    Blancpain, Bovet, Breguet jt. Saate eseme pantida,
                    ilma et peaksite muretsema kõrgete intresside pärast. Hindame kellasid ausalt ja pakume kõrgeid hindu.</p>
                <p>Meie pandimaja ostab ehteid, investeerimismünte, väärismetallide kange ja
                    jäätmeid börsikursiga, pakkudes Tallinna kõrgeimat hinda. Hindamine toimub seejuures kiiresti –
                    online-režiimil kõigest 5-10 minutiga, isikliku visiidi puhul aga veelgi kiiremini.</p>

                <p>Kui hind teid rahuldab, ootame teid oma kontorisse! Kui aga hind ületab 500 eurot,
                    võime teie aadressil ise kohale tulla.</p>


                <div class="card-menu-page__item-buttons">
                    <button onclick="window.location='/e-hindamine/';"> E-HINDAMA <span class="tke-icon-menu-right"></button>
                    <button onclick="window.location='https://api.whatsapp.com/send?phone=3725014769';" class="whatsapp-button social-valutation"> Whatsapp Hindamine</button>
                    <button onclick="window.location='viber://add?number=3725014769';" class="viber-button social-valutation"> Viber Hindamine</button>
                </div>

            </div>

            <div class="card-menu-page__item-inside">

                <img src="<?= get_template_directory_uri(); ?>/img/pantteenus.jpg"  alt="Pandimaja" width="512" height="384"/>

            </div>

        </div>

        <div class="online-valuation">

            <div class="online-valuation__section">

                <div class="online-valuation__item">

                    <h1>TALLINNA PANDIMAJA</h1>

                    <p>see on Tallinnas asuv kellade eliitpandimaja. Oleme juba üle 30 aasta
                        olnud Šveitsi kellade ja juveelide kokkuostu, müügi, pantimise ja hindamise
                        turul ning oleme saavutanud hea maine. Meie peamine eelis võrreldes teistega on parimad tingimused sularaha väljamaksetes:
                        alates 1000 eurost kuni 10 000 euroni kõigest 15 minutiga.</p>

                    <button onclick="window.location='/teenused/';">UURI LISAKS <span class="tke-icon-menu-right"></span</button>

                </div>

                <div class="online-valuation__item">

                    <img src="<?= get_template_directory_uri(); ?>/img/kellsormus.png"  alt="Kellade pant" width="512" height="384"/>

                </div>

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