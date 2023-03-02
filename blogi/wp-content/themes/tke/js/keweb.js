
$(document).ready(function() {
    if ($('#wpadminbar')[0]) {
        $('.navbg, .logo-nav').css('top', '32px')
    }
});

jQuery(document).ready(function() {
jQuery(".js-main").click(function(){
    $(this).toggleClass('js-open');
    $(this).siblings('.js-secondary').toggleClass('js-show');
  });
    $(".js-language-menu-header").click(function () {
        $(this).siblings().toggleClass('js-show');
    });
});
