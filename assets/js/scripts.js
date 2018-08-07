jQuery(document).ready(function($) {
  var alert, body, burger, checkIdentity, closeOverlay, fillDays, filterItems, gridView, header, headerPlaceholder, identity, intro, itemRows, itemsLoop, listView, main, mainInner, nav, openOverlay, overlayPlaceholder, setupGallery;
  body = $('body');
  nav = $('nav');
  header = $('header');
  headerPlaceholder = $('.header-placeholder');
  identity = $('#identity');
  intro = $('#intro');
  alert = $('#alert');
  main = $('main');
  mainInner = $('.main-inner');
  burger = $('.burger');
  overlayPlaceholder = $('.overlay.placeholder');
  itemsLoop = $('.loop');
  itemRows = $('.item-row');
  gridView = itemsLoop.find('.grid-view');
  listView = itemsLoop.find('.list-view');
  fillDays = function() {
    return $('.grid-view .day-loop').each(function(i, gridDayLoop) {
      var date;
      date = $(gridDayLoop).attr('data-date');
      return $.ajax({
        url: ajax_obj.ajaxurl,
        type: 'POST',
        dataType: 'html',
        data: {
          date: date,
          action: 'get_day_of_events'
        },
        success: function(html) {
          var blocks, listDayLoop, rows;
          if (html.length) {
            $(gridDayLoop).find('.block.placeholder').remove();
            blocks = $(html).filter('.event-block');
            rows = $(html).filter('.event-row');
            blocks.each(function(i, block) {
              return $(gridDayLoop).append(block);
            });
            $(gridDayLoop).addClass('show');
            listDayLoop = listView.find('[data-date="' + date + '"]');
            rows.each(function(i, row) {
              return listDayLoop.append(row);
            });
            if (itemsLoop.attr('data-view') === 'list') {
              return filterItems();
            }
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
  body.on('click', '.nav-icon.burger', function() {
    nav.addClass('open');
    body.addClass('header-open');
    return $(window).scroll();
  });
  body.on('click', '.nav-icon.x', function() {
    nav.removeClass('open');
    body.removeClass('header-open');
    return $(window).scroll();
  });
  body.on('click', '.menu-item.archive span', function() {
    $(this).toggleClass('active');
    return $('.menu-item.year').each(function(i, item) {
      return setTimeout(function() {
        return $(item).toggleClass('show');
      }, i * 50);
    });
  });
  body.on('click', '.calendar .clear', function() {
    $('.calendar .day').addClass('active secret');
    return filterItems();
  });
  body.on('click', '.header-row .label.mobile', function() {
    return header.toggleClass('show-toggles');
  });
  body.on('click', '.sort-header', function() {
    var col, sort;
    col = $(this).parents('.col-header');
    return sort = col.attr('data-sort');
  });
  body.on('click', '.toggle', function() {
    var filter, sib, toggle, toggles, view;
    toggle = $(this);
    view = toggle.attr('data-view');
    filter = toggle.attr('data-filter');
    toggles = toggle.parents('.toggles').find('.toggle');
    toggles.filter('.secret').each(function(i, secret) {
      return $(secret).removeClass('active secret');
    });
    if (view) {
      sib = toggle.siblings('.view');
      sib.removeClass('active');
      $('.events-loop').attr('data-view', view);
      return toggle.addClass('active');
    } else if (filter) {
      toggle.toggleClass('active');
      if (!toggles.filter('.active').length) {
        toggles.addClass('active secret');
      }
      return filterItems();
    } else if ($(this).is('.hide-past')) {
      $(this).toggleClass('active');
      return itemsLoop.toggleClass('hide-past');
    }
  });
  filterItems = function() {
    var filters, items, j, len, results, selected, tax, toggles, view;
    filters = [];
    view = itemsLoop.attr('data-view');
    if (view === 'grid') {
      toggles = $('header .toggle.filter');
      items = itemsLoop.find('.item.block');
    } else if (view === 'list') {
      if (itemsLoop.is('#events-loop')) {
        toggles = $('.list-header .toggle.filter');
      } else if (itemsLoop.is('#partners-loop')) {
        toggles = $('.header-row .toggle.filter');
      }
      items = itemsLoop.find('.item-row');
    }
    toggles.each(function(i, toggle) {
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
    items.removeClass('hide');
    results = [];
    for (j = 0, len = filters.length; j < len; j++) {
      tax = filters[j];
      selected = filters[tax];
      results.push(items.each(function(i, item) {
        var k, len1, show, term, terms;
        terms = $(item).attr('data-' + tax);
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
            return $(item).addClass('hide');
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
    overlayPlaceholder.find('.x').attr('href', location.href);
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
    body.addClass('overlay-open');
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
        console.log(error);
        return closeOverlay();
      }
    });
  };
  closeOverlay = function() {
    var id, item, offset, overlay, parent, scrollTop, target;
    body.removeClass('overlay-open');
    overlay = $('.overlay[data-id]');
    id = overlay.attr('data-id');
    if (!id) {
      overlay.removeClass('show');
      overlayPlaceholder.removeClass('show');
      return;
    }
    item = $('.item').filter('[data-id="' + id + '"]');
    parent = item.parents('.loop');
    offset = header.innerHeight();
    if (parent.attr('data-view') === 'grid' || parent.is('.exhibitions-loop')) {
      target = item.parents('.row');
    } else {
      target = item.filter('.item-row');
      offset += $('.list-header .fix').innerHeight();
    }
    scrollTop = target.offset().top - offset;
    $(window).scrollTop(scrollTop);
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
  if (localStorage.getItem('hide-alert')) {
    alert.remove();
  } else {
    alert.addClass('show');
  }
  body.on('click', '#alert .x', function() {
    localStorage.setItem('hide-alert', true);
    return alert.remove();
  });
  $(window).resize(function() {
    return $(window).scroll();
  }).resize();
  checkIdentity = function() {
    if (sessionStorage.getItem('hide-identity')) {
      identity.remove();
      return body.addClass('header-fixed');
    } else {
      return identity.addClass('show');
    }
  };
  $(window).scroll(function(e) {
    var headerBottom, headerHeight, mainTop, scrollTop, topHeight;
    checkIdentity();
    scrollTop = $(window).scrollTop();
    mainTop = main.offset().top;
    headerHeight = header.innerHeight();
    headerBottom = headerHeight;
    topHeight = headerHeight;
    $('[data-view="grid"] .date-header, [data-view="list"] .list-header').each(function() {
      var fixHeight, thisFix, thisHeader, thisTop;
      thisHeader = $(this);
      thisFix = thisHeader.find('.fix');
      thisTop = thisHeader.offset().top;
      fixHeight = thisFix.innerHeight();
      if (thisTop <= scrollTop + headerBottom) {
        thisHeader.addClass('fixed').css({
          height: fixHeight
        });
        return thisFix.css({
          top: headerBottom
        });
      } else {
        thisHeader.removeClass('fixed').attr('style', '');
        return thisFix.attr('style', '');
      }
    });
    if (!topHeight) {
      topHeight = headerHeight;
    }
    if (mainTop <= scrollTop) {
      sessionStorage.setItem('hide-identity', true);
      identity.remove();
      mainInner.css({
        marginTop: topHeight
      });
      return body.addClass('header-fixed');
    } else {
      return body.removeClass('header-fixed');
    }
  }).scroll();
  setupGallery();
  return fillDays();
});
