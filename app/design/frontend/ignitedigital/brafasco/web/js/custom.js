require([ "jquery" ], function($) {
    if( $(window).width() >= 768 ) {
        $(window).scroll(function() {
            if ($(window).scrollTop() > $('.page-header').offset().top && !($('.body').hasClass('sticky')) && !($('.home-special').hasClass('sticky')) && !($('.sections.nav-sections').hasClass('sticky'))) {
                $('.sections.nav-sections').addClass('sticky');
                $('.home-special').addClass('sticky');
                $('.sections.nav-sections .navigation').prepend('<div class="sticky-logo"></div>');
                $('.sections.nav-sections.sticky').addClass('fadeInDown');
                $('.home-special.sticky').addClass('fadeInDown');
                $('.sections.nav-sections.sticky').removeClass('fadeOutUp');
                $('.home-special.sticky').removeClass('fadeOutUp');
                $('.sections.nav-sections.sticky').addClass('animated');
                $('.home-special.sticky').addClass('animated');

                } else if ($(window).scrollTop() == 0) {
                $('.sections.nav-sections.sticky').addClass('fadeOutUp');
                $('.sections.nav-sections.sticky').removeClass('fadeInUp');
                $('.sections.nav-sections.sticky').removeClass('animated');
                $('.sections.nav-sections').removeClass('sticky');
                $(".sections.nav-sections .navigation > .sticky-logo").remove();
                $('.home-special.sticky').addClass('fadeOutUp');
                $('.home-special.sticky').removeClass('fadeInUp');
                $('.home-special.sticky').removeClass('animated');
                  $('.home-special').removeClass('sticky');


            }
        });
    }
    else
    {
        $(window).scroll(function() {
          if ($(window).scrollTop() > $('.page-header').offset().top && !($('.body').hasClass('sticky')) && !($('.home-special').hasClass('sticky')) && !($('.sections.nav-sections').hasClass('sticky'))) {
              $('.page-header').addClass('sticky');
              $('.home-special').addClass('sticky');
              $('.page-header.sticky').addClass('fadeInDown');
              $('.home-special.sticky').addClass('fadeInDown');
              $('.page-header.sticky').removeClass('fadeOutUp');
              $('.home-special.sticky').removeClass('fadeOutUp');
              $('.page-header.sticky').addClass('animated');
              $('.home-special.sticky').addClass('animated');
            } else if ($(window).scrollTop() == 0) {
              $('.page-header.sticky').addClass('fadeOutUp');
              $('.page-header.sticky').removeClass('fadeInUp');
              $('.page-header.sticky').removeClass('animated');
                $('.page-header').removeClass('sticky');
                $('.home-special.sticky').addClass('fadeOutUp');
                $('.home-special.sticky').removeClass('fadeInUp');
                $('.home-special.sticky').removeClass('animated');
                $('.home-special').removeClass('sticky');
            }
        });
    }
});
