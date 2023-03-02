<!doctype html>
<html>

<head>
  <meta name="description" content="see on Tallinnas asuv kellade eliitpandimaja. 
  Oleme juba üle 30 aasta olnud Šveitsi kellade ja juveelide kokkuostu, müügi, pantimise ja hindamise turul 
  ning oleme saavutanud hea maine. Meie peamine eelis võrreldes teistega on parimad tingimused sularaha väljamaksetes: 
  alates 1000 eurost kuni 10 000 euroni kõigest 15 minutiga.">

  <meta charset="utf-8">
  <title>TKE Pandimaja OÜ | Kellade pandimaja</title>
  <?php wp_head(); ?>

  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  <script type="text/javascript" src="https://www.bullionvault.com/chart/bullionvaultchart.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@100;200;300;400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Google Tag Manager -->

<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':

new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],

j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=

'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);

})(window,document,'script','dataLayer','GTM-K3G7SZ7');</script>

<!-- End Google Tag Manager -->

</head>

<div class="navigation-wrapper">
  <nav class="navbar navbar-expand-lg navbar-light">

    <button onclick="this.classList.toggle('opened');this.setAttribute('aria-expanded', this.classList.contains('opened'))" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-content" aria-controls="navbar-content" aria-expanded="false" aria-label="<?php esc_html_e('Toggle Navigation', 'theme-textdomain'); ?>">
      <svg width="50" height="50" viewBox="0 0 100 100">
        <path class="line line1" d="M 20,29.000046 H 80.000231 C 80.000231,29.000046 94.498839,28.817352 94.532987,66.711331 94.543142,77.980673 90.966081,81.670246 85.259173,81.668997 79.552261,81.667751 75.000211,74.999942 75.000211,74.999942 L 25.000021,25.000058" />
        <path class="line line2" d="M 20,50 H 80" />
        <path class="line line3" d="M 20,70.999954 H 80.000231 C 80.000231,70.999954 94.498839,71.182648 94.532987,33.288669 94.543142,22.019327 90.966081,18.329754 85.259173,18.331003 79.552261,18.332249 75.000211,25.000058 75.000211,25.000058 L 25.000021,74.999942" />
      </svg>
      <span class="nav-title">MENÜÜ</span>
    </button>

    <div class="collapse navbar-collapse" id="navbar-content">
      <?php
      wp_nav_menu(array(
        'theme_location' => 'primary', // Defined when registering the menu
        'menu_id'        => 'primary-menu',
        'container'      => false,
        'depth'          => 2,
        'menu_class'     => 'navbar-nav ml-auto mr-auto',
        'walker'         => new Bootstrap_NavWalker(), // This controls the display of the Bootstrap Navbar
        'fallback_cb'    => 'Bootstrap_NavWalker::fallback', // For menu fallback
      ));

      ?>

    </div>

  </nav>
</div>

<div class="page-wrapper">

  <?php
  if($post) {
  global $post;
  $post_slug = $post->post_name;
  }else{
      $post_slug = '';
  }
   $home_url = 'https://tkepandimaja.ee/';
  $curret_rus_link = $home_url . '/ru/' . $post_slug;
   if($post_slug == 'tere-tere'){
  $curret_rus_link = $home_url;
  }else
  {
	  $curret_rus_link = $home_url . $post_slug;
  }

  ?>

  <div class="custom-header">

    <ul class="js-language-menu">

      <li class="js-language-menu-header"><img src="<?= get_template_directory_uri(); ?>/img/rus.jpg" alt="ломбард на русском" width="64" height="43"></li>
      <li><a href="<?= esc_url($curret_rus_link); ?>"><img src="<?= get_template_directory_uri(); ?>/img/est.jpg" alt="Pandimaja Eesti Keel" width="64" height="41"></a></li>

    </ul>

    <div class="custom-header__inside">

      <div class="custom-logo"><?php the_custom_logo(); ?></div>

    </div>
  </div>

  <div class="social-bubble">

    <div class="social-bubble__bubble js-main">

    </div>

    <div class="social-bubble__bubble js-secondary">

      <a href="mailto:kellapandimaja@tkepandimaja.ee"></a>
    </div>

    <div class="social-bubble__bubble js-secondary">
      <a href="viber://add?number=3725014769"></a>
    </div>

    <div class="social-bubble__bubble js-secondary">
      <a href="https://telegram.me/5014769"></a>
    </div>

    <div class="social-bubble__bubble js-secondary">
      <a href="https://api.whatsapp.com/send?phone=3725014769"></a>
    </div>

    <div class="social-bubble__bubble js-secondary">

      <a href="tel:+372 5014769"></a>
    </div>

  </div>

  <div class="js-bank-detail-nr">
    Pangakonto: <b>EE777700771003683711</b> - Lepingute pikendamiseks või tagasimakseteks
  </div>

  <body>

  <!-- Google Tag Manager (noscript) -->

<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K3G7SZ7"

height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>

<!-- End Google Tag Manager (noscript) -->