<!doctype html>
<html>

  <head>

    <meta charset="utf-8">
    <title>TKEPANDIMAJA BLOGI</title>
    <?php wp_head(); ?>
    
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
     <meta name="viewport" content="width=device-width, initial-scale=1">
     
     <link href="https://fonts.googleapis.com/css?family=Montserrat:200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">
     <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&display=swap" rel="stylesheet">
     
    
    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-166180590-1"></script>
<script>
$(document).ready(function() {
    if ($('#wpadminbar')[0]) {
        $('.navbg, .logo-nav').css('top', '32px')
    }
});


</script>

    
</head>

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

<div class="logo-nav">

<nav class="navbar navbar-expand-lg navbar-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-content" aria-controls="navbar-content" aria-expanded="false" aria-label="<?php esc_html_e( 'Toggle Navigation', 'theme-textdomain' ); ?>">
        <span class="navbar-toggler-icon"></span>
    </button>
 
    <div class="collapse navbar-collapse" id="navbar-content">
            <?php
        wp_nav_menu( array(
            'theme_location' => 'primary', // Defined when registering the menu
            'menu_id'        => 'primary-menu',
            'container'      => false,
            'depth'          => 2,
            'menu_class'     => 'navbar-nav mx-auto',
            'walker'         => new Bootstrap_NavWalker(), // This controls the display of the Bootstrap Navbar
            'fallback_cb'    => 'Bootstrap_NavWalker::fallback', // For menu fallback
        ) );
    
    
        ?>
    
    </div>
</nav>

</div>
<div class="navbg"></div>
<div class="custom-header">
  
    <ul class="js-language-menu">

      <li class="js-language-menu-header"><img src="<?= get_template_directory_uri(); ?>/img/est.jpg" alt="Pandimaja Eesti Keel" width="64" height="41"></li>
      <li><a href="https://tkepandimaja.ee/blogi/ru"><img src="<?= get_template_directory_uri(); ?>/img/rus.jpg" alt="ломбард на русском" width="64" height="43"></a></li>

    </ul>



<div class="title-tagline">

<h1 class="header-title"><span><?php bloginfo('name'); ?></span></h1>

</div>





</div>

<body>