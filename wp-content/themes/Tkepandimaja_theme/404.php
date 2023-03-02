<?php get_header(); ?>
<div class="page-content">
<div class="error-page">
<h1>404</h1>
<h1>Antud lehekülge ei eksisteeri</h1>
<p>Lehekülg mida avasite ei ole olemas. Võib-olla lehekülge on muudetud, kustutatud või ei ole kunagi olemas olnud</p>
<button onclick="window.location='<?= get_home_url(); ?>';"> Tagasi kodulehele <span class="tke-icon-menu-right"></span></button>
</div>
</div>
</div>
<?php get_footer(); ?>