$(document).ready(function () {

    if ($('#wpadminbar').length > 0) {
        $('.navigation-wrapper').css('top', '32px');
    }

    $(".js-language-menu-header").click(function () {
        $(this).siblings().toggleClass('js-show');
    });

    $(".card-menu__card").hover3d({
        selector: ".card-menu__card-inside",
        shine: true,
    });

    if ($('.gold-table').length > 0) {
        var options = {
            bullion: 'gold',
            currency: 'EUR',
            timeframe: '1w',
            chartType: 'line',
            miniChartModeAxis: 'kg',
            containerDefinedSize: true,
            miniChartMode: false,
            displayLatestPriceLine: true,
            switchBullion: false,
            switchCurrency: false,
            switchTimeframe: false,
            switchChartType: false,
            exportButton: false
        };
        var chartBV = new BullionVaultChart(options, 'embed');
    }

    $('.js-service-menu').children('a:first').addClass('js-active-menu');

    $(".js-menu-item").click(function (e) {
        e.preventDefault();
        $([document.documentElement, document.body]).animate({
            scrollTop: $(".services-page__content").offset().top
        }, 300);
        $(this).siblings().removeClass('js-active-menu');
        $(this).addClass('js-active-menu');
        var jsmenuvalue = $(this).attr('href');
        console.log(jsmenuvalue);
        $(jsmenuvalue).fadeIn(1000);
        $(jsmenuvalue).siblings().hide();
    });

    jQuery(document).ready(function () {
        jQuery(".js-main").click(function () {
            $(this).toggleClass('js-open');
            $(this).siblings('.js-secondary').toggleClass('js-show');
        });
    });

    $(window).scroll(function () {
        if ($(this).scrollTop() < 400) {
            $('.js-bank-detail-nr').slideDown(500);
            $(".social-bubble").css('cssText', 'bottom: 52px !important');
        } else {
            $('.js-bank-detail-nr').slideUp(500);
            $(".social-bubble").css('cssText', 'bottom: 12px !important');
        }
    });


    var secondsection = $('.online-valuation__item');

    if (secondsection.length) {
        var s = $(".online-valuation__item").offset().top;

        $(document).scroll(function () {
            if ($(window).height() + $(this).scrollTop() > s) {
                $('.online-valuation__item').addClass('slidefromleft');
            }
        });
    }

    $('.card-menu-page__item-inside img').addClass('slidefromright');
  
});