jQuery(document).ready(function($) {
  var archive, burger, headersMobile, mobileNav, title, years;
  mobileNav = $('header.mobile nav');
  burger = $('.burger');
  title = $('nav .title');
  archive = $('nav .archive');
  years = $('nav .years');
  headersMobile = $('.headers-mobile');
  archive.on('click', function(e) {
    var header, height, nav;
    nav = $(this).parents('nav');
    years = nav.find('.years');
    years.toggleClass('show');
    header = nav.parents('header');
    $(window).resize();
    if (header.length) {
      height = title.innerHeight();
      if (years.is('.show')) {
        height = nav.find('.title').innerHeight() + years.innerHeight() + 15;
      } else {
        height = 'auto';
      }
      return header.css({
        height: height
      });
    }
  });
  burger.on('click', function(e) {
    return mobileNav.toggleClass('show');
  });
  $(window).resize(function() {
    if (title.find('.label').innerHeight() > archive.find('.label').innerHeight()) {
      years.addClass('static');
    } else {
      years.removeClass('static');
    }
    return $(window).scroll();
  }).resize();
  return $(window).scroll(function(e) {
    var headersMobileTop;
    headersMobileTop = headersMobile.position().top - $(window).scrollTop();
    if (headersMobileTop <= 0) {
      return headersMobile.addClass('passed');
    } else {
      return headersMobile.removeClass('passed');
    }
  }).scroll();
});
