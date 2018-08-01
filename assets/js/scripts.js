jQuery(document).ready(function($) {
  var body, burger, closeOverlay, eventsLoop, fillDays, filterList, header, headerPlaceholder, headerWrap, identity, itemRows, main, openOverlay, overlayPlaceholder, setupGallery;
  body = $('body');
  headerWrap = $('.header-wrap');
  header = $('header');
  headerPlaceholder = $('.header-placeholder');
  identity = $('#identity');
  main = $('main');
  burger = $('.burger');
  overlayPlaceholder = $('.overlay.placeholder');
  eventsLoop = $('.events-loop');
  itemRows = $('.item-row');
  fillDays = function() {
    return $('.day-loop').each(function(i, day) {
      var date;
      date = $(day).attr('data-date');
      return $.ajax({
        url: ajax_obj.ajaxurl,
        type: 'POST',
        dataType: 'html',
        data: {
          date: date,
          action: 'get_day_of_events'
        },
        success: function(html) {
          if (html.length) {
            $(day).append(html);
            return $(day).addClass('show');
          } else {
            return $(day).remove();
          }
        },
        error: function(error) {
          return console.log(error);
        }
      });
    });
  };
  identity.on('click', function() {
    var top;
    top = $(this).position().top + $(this).innerHeight();
    return $('html, body').animate({
      scrollTop: top + 'px'
    }, 200);
  });
  $(window).scroll(function(e) {
    var headerBottom, identityBottom, scrollTop;
    scrollTop = $(window).scrollTop();
    headerBottom = header.position().top + header.innerHeight();
    identityBottom = identity.innerHeight();
    if (identityBottom <= scrollTop) {
      body.addClass('header-fixed');
      return $('.date-header').each(function() {
        var dateTop;
        dateTop = $(this).offset().top;
        if (dateTop <= scrollTop + headerBottom) {
          $(this).addClass('fixed');
          return $(this).find('.fix').css({
            top: headerBottom
          });
        } else {
          return $(this).removeClass('fixed');
        }
      });
    } else {
      return body.removeClass('header-fixed');
    }
  }).scroll();
  body.on('click', 'header .burger', function() {
    return header.addClass('open');
  });
  body.on('click', 'header .x', function() {
    return header.removeClass('open');
  });
  body.on('click', '.menu-item.archive', function() {
    $(this).toggleClass('active');
    return $('.menu-item.year').each(function(i, item) {
      return setTimeout(function() {
        return $(item).toggleClass('show');
      }, i * 50);
    });
  });
  body.on('click', '.calendar .clear', function() {
    $('.calendar .day').addClass('active secret');
    return filterList();
  });
  body.on('click', '.header-row .label.mobile', function() {
    return header.toggleClass('show-toggles');
  });
  body.on('click', '.toggle', function() {
    var filter, sib, view;
    view = $(this).attr('data-view');
    filter = $(this).attr('data-filter');
    if ($(this).is('.day')) {
      $('.calendar .filter.secret').removeClass('secret active');
    }
    if (view) {
      sib = $(this).siblings('.view');
      sib.removeClass('active');
      $('.events-loop').attr('data-view', view);
      return $(this).addClass('active');
    } else if (filter) {
      $(this).toggleClass('active');
      return filterList();
    } else if ($(this).is('.hide-past')) {
      $(this).toggleClass('active');
      return eventsLoop.toggleClass('hide-past');
    }
  });
  filterList = function() {
    var filters, j, len, results, selected, tax;
    filters = [];
    $('.toggle.filter').each(function(i, toggle) {
      var filter, selector, slug;
      filter = $(toggle).attr('data-filter');
      slug = $(toggle).attr('data-slug');
      selector = '.' + filter + '-' + slug;
      if (!filters[filter]) {
        filters.push(filter);
        filters[filter] = [];
      }
      if ($(toggle).is('.active')) {
        return filters[filter].push(slug);
      }
    });
    itemRows.removeClass('hide');
    results = [];
    for (j = 0, len = filters.length; j < len; j++) {
      tax = filters[j];
      selected = filters[tax];
      results.push(itemRows.each(function(i, itemRow) {
        var k, len1, show, term, terms;
        terms = $(itemRow).attr('data-' + tax);
        if (terms) {
          terms = terms.split(',');
          show = false;
          for (k = 0, len1 = terms.length; k < len1; k++) {
            term = terms[k];
            if (selected.indexOf(term) >= 0) {
              show = true;
            }
          }
          if (!show) {
            return $(itemRow).addClass('hide');
          }
        }
      }));
    }
    return results;
  };
  body.on('click', '.item-link', function(e) {
    var id, item, postType, state, url;
    e.preventDefault();
    item = $(this).parents('.item');
    if (item.is('.event_type-botd')) {
      overlayPlaceholder.addClass('botd');
    } else {
      overlayPlaceholder.removeClass('botd');
    }
    overlayPlaceholder.addClass('show');
    url = this.href;
    id = item.attr('data-id');
    postType = item.attr('data-post-type');
    state = {
      action: 'open',
      url: window.location.href,
      postType: postType,
      id: id
    };
    history.pushState(state, null, url);
    return openOverlay(id, postType);
  });
  body.on('click', '.overlay .x', function(e) {
    var overlay, state, url;
    e.preventDefault();
    url = this.href;
    state = {
      action: 'close'
    };
    history.pushState(state, null, url);
    overlay = $(this).parents('.overlay');
    return closeOverlay();
  });
  body.on('click', '#alert .x', function(e) {
    return $('#alert').remove();
  });
  window.onpopstate = function() {
    if (!history.state) {
      return;
    }
    if (history.state.action === 'open') {
      return openOverlay(history.state.id, history.state.postType);
    } else if (history.state.action === 'close') {
      return closeOverlay();
    }
  };
  openOverlay = function(id, postType) {
    return $.ajax({
      url: ajax_obj.ajaxurl,
      type: 'POST',
      dataType: 'html',
      data: {
        id: id,
        post_type: postType,
        action: 'get_overlay'
      },
      success: function(html) {
        main.prepend(html);
        setupGallery();
        overlayPlaceholder.removeClass('show');
        return header.removeClass('open');
      },
      error: function(error) {
        return console.log(error);
      }
    });
  };
  closeOverlay = function() {
    var id, item, overlay, scrollTop, target;
    overlay = $('.overlay[data-id]');
    id = $(overlay).attr('data-id');
    item = $('.item').filter('[data-id="' + id + '"]');
    if ($('.loop').is(['data-view="grid"']) || $('.loop').is('.exhibitions-loop')) {
      target = item.parents('.row');
    } else {
      target = item.filter('.item-row');
    }
    scrollTop = target.offset().top - header.innerHeight();
    $(window).scrollTop(scrollTop - 30);
    return overlay.remove();
  };
  body.on('click', '.gallery .dot', function(e) {
    var caption, dot, figure, gallery, index;
    index = $(this).attr('data-index');
    gallery = $(this).parents('.gallery');
    figure = gallery.find('figure[data-index="' + index + '"]');
    dot = gallery.find('.dot[data-index="' + index + '"]');
    caption = gallery.find('figcaption[data-index="' + index + '"]');
    if (!figure) {
      return;
    }
    gallery.find('.active').removeClass('active');
    dot.addClass('active');
    caption.addClass('active');
    return figure.addClass('active');
  });
  setupGallery = function() {
    var gallery, images;
    gallery = $('.gallery');
    images = gallery.find('img');
    return images.imagesLoaded().progress(function(instance, image) {
      var $img, figure, ref, result;
      $img = $(image.img);
      result = (ref = image.isLoaded) != null ? ref : {
        'loaded': 'broken'
      };
      figure = $img.parent();
      return figure.addClass('loaded');
    });
  };
  setupGallery();
  return fillDays();
});
