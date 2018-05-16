jQuery(document).ready(function($) {
  var archive, title, years;
  title = $('nav .title');
  archive = $('nav .archive');
  years = $('nav .years');
  archive.find('a').on('click', function(e) {
    return years.toggleClass('show');
  });
  return $(window).resize(function() {
    if (title.find('.label').innerHeight() > archive.find('.label').innerHeight()) {
      return years.addClass('static');
    } else {
      return years.removeClass('static');
    }
  }).resize();
});
