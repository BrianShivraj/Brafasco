require([ "jquery" ], function($){

  var stickySidebar = $j('nav-sections').offset().top;
  $j(window).scroll(function() {
      scrollTop = $j(window).scrollTop();

      if (scrollTop > stickySidebar && !$j('body').hasClass('sticky')) {
          $j('body').addClass('sticky');
      }

      if (scrollTop < 55 && $j('body').hasClass('sticky')) {
          $j('body').removeClass('sticky');
      }
  });

});
