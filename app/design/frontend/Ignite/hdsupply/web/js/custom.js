require([ "jquery" ], function($) {
    if( $(window).width() >= 768 ) {
        $(window).scroll(function() {
            if ($(window).scrollTop() > $('.page-header').offset().top && !($('.body').hasClass('sticky')) && !($('.home-special').hasClass('sticky')) && !($('.sections.nav-sections').hasClass('sticky'))) {
                $('.page-header').addClass('sticky');
                $('.sections.nav-sections').addClass('sticky');
                $('.sections.nav-sections').prepend('<div class="sticky-logo">Prepended item<</div>);
                $('.home-special').addClass('sticky');
            } else if ($(window).scrollTop() == 0) {
                $('.page-header').removeClass('sticky');
                $('.sections.nav-sections').removeClass('sticky');
                  $('.sections.nav-sections').remove('<div class="sticky-logo">Prepended item<</div>);
                  $('.home-special').removeClass('sticky');
            }
        });
    }
    else
    {
        $(window).scroll(function() {
            if ($(window).scrollTop() > $('.page-header').offset().top && !($('.body').hasClass('sticky')) && !($('.home-special').hasClass('sticky')) && !($('.page-main').hasClass('paddingm'))) {
                $('.page-header').addClass('sticky');
                $('.page-main').addClass('paddingm');
            } else if ($(window).scrollTop() == 0) {
                $('.page-header').removeClass('sticky');
                $('.page-main').removeClass('paddingm');
            }
        });
    }
define(["jquery"], function ($) {


        $(window).scroll(function () {
            if ($(window).width() >= 767) {
                if (140 < $(window).scrollTop() && !scrolled) {
                    $(".page-header").addClass("sticky-header");
                    $(".sections.nav-sections").addClass("sticky-header-nav-sections");
                    scrolled = true;
                    $(".page-header .minicart-wrapper").after('<div class="minicart-place hide"></div>');
                    var minicart = $(".page-header .minicart-wrapper").detach();
                    $(".sticky-header-nav-sections .navigation").append(minicart);
                     {
                        var logo_image = $("<div>").append($(".page-header .header > .logo").clone()).html();
                        $(".sticky-header-nav-sections .navigation").prepend('<div class="sticky-logo">' + logo_image + "</div>");
                         {
                            var imageUrl = "http://magento.local/media/logo/stores/1/logo.gif";
                            $(".sticky-logo img").attr("src", imageUrl);
                        }
                    }
                }
                if (140 >= $(window).scrollTop() && scrolled) {
                    $(".page-header").removeClass("sticky-header");
                    $(".sections.nav-sections").removeClass("sticky-header-nav-sections");
                    scrolled = false;
                        {
                        $(".sections.nav-sections .navigation > .sticky-logo").remove();
                    }
                }

        });
    };
});
