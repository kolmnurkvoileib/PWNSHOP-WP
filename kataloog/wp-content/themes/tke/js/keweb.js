jQuery(document).ready(function() {
jQuery(".js-main").click(function(){
    $(this).toggleClass('js-open');
    $(this).siblings('.js-secondary').toggleClass('js-show');
  });
});