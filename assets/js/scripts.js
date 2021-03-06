jQuery(document).ready(function($) {
  var alert, body, burger, checkIdentity, closeOverlay, eventsPool, fillEventsBlocks, fillEventsRows, filterItems, fixMobileView, getEventsBlocks, gridView, header, headerPlaceholder, identity, intro, isMobile, itemRows, itemsLoop, listView, main, mainInner, nav, openOverlay, overlayPlaceholder, setupGallery;
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
  eventsPool = $('#events-pool');
  getEventsBlocks = function() {
    return $.ajax({
      url: ajax_obj.ajaxurl,
      type: 'POST',
      dataType: 'html',
      data: {
        action: 'get_events_blocks'
      },
      success: function(html) {
        return fillEventsBlocks($(html).filter('.event'));
      },
      error: function(jqXHR, textStatus, errorThrown) {
        return console.log(jqXHR, textStatus, errorThrown);
      }
    });
  };
  fillEventsBlocks = function(blocks) {
    return blocks.each(function(i, block) {
      var day, dayLoop, days, j, len, results;
      block = $(block);
      days = $(block).attr('data-days').split(',');
      results = [];
      for (j = 0, len = days.length; j < len; j++) {
        day = days[j];
        if (day !== 1 && day !== '1') {
          dayLoop = $('.day-loop[data-day="' + day + '"]');
          dayLoop.addClass('show');
          results.push(dayLoop.append(block.clone()));
        } else {
          results.push(void 0);
        }
      }
      return results;
    });
  };
  fillEventsRows = function() {
    return $.ajax({
      url: ajax_obj.ajaxurl,
      type: 'POST',
      dataType: 'html',
      data: {
        action: 'get_events_rows'
      },
      success: function(html) {
        listView.append(html);
        return filterItems();
      },
      error: function(jqXHR, textStatus, errorThrown) {
        return console.log(jqXHR, textStatus, errorThrown);
      }
    });
  };
  identity.on('click', function() {
    var top;
    top = $(this).innerHeight();
    return $('html, body').animate({
      scrollTop: top + 'px'
    }, 200, function() {
      identity.remove();
      return $(window).scrollTop(0);
    });
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
  body.on('click', '.date-header .arrow', function() {
    var day, direction, targetDate, targetDay, targetTop;
    direction = $(this).attr('data-direction');
    day = $(this).parents('.day-loop');
    if (direction === 'next') {
      targetDay = day.next();
    } else if (direction === 'prev') {
      targetDay = day.prev();
    } else {
      return;
    }
    targetDate = targetDay.find('.date-header');
    targetTop = targetDate.offset().top - header.innerHeight() + 5;
    return $('html, body').animate({
      scrollTop: targetTop + 'px'
    }, 200);
  });
  body.on('click', '.toggle', function() {
    var filter, sib, slug, toggle, toggles, view;
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
      toggle.addClass('active');
      $(window).scroll();
      return filterItems();
    } else if (filter) {
      slug = toggle.attr('data-slug');
      if (slug !== 'clear') {
        toggle.toggleClass('active');
      }
      if (!toggles.filter('.active').length || slug === 'clear') {
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
    if (view === 'grid' && isMobile()) {
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
    if (toggles) {
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
    }
  };
  body.on('click', '.item-link', function(e) {
    var id, item, postType, state, url;
    e.preventDefault();
    item = $(this).parents('.item');
    id = item.attr('data-id');
    if (!id) {
      return;
    }
    if (item.is('.no-gallery')) {
      overlayPlaceholder.addClass('no-gallery');
    }
    overlayPlaceholder.find('.x').attr('href', location.href);
    if (item.is('.event_type-botd')) {
      overlayPlaceholder.addClass('botd');
    } else {
      overlayPlaceholder.removeClass('botd');
    }
    overlayPlaceholder.addClass('show');
    url = this.href;
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
        body.addClass('overlay-open');
        main.prepend(html);
        setupGallery();
        setTimeout(function() {
          return main.find('.overlay:not(.placeholder)').addClass('show');
        }, 200);
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
    item = $('.item').filter('[data-id="' + id + '"]');
    overlayPlaceholder.removeClass('no-gallery');
    if (!item.length) {
      overlay.removeClass('show');
      overlayPlaceholder.removeClass('show');
      setTimeout(function() {
        return overlay.remove();
      }, 200);
      return;
    }
    parent = item.parents('.loop');
    offset = header.innerHeight();
    if (parent.attr('data-view') === 'grid' || parent.is('.exhibitions-loop')) {
      target = item.parents('.row');
    } else {
      target = item.filter('.item-row');
      offset += $('.list-header .fix').innerHeight();
    }
    scrollTop = target.offset().top - offset;
    overlayPlaceholder.removeClass('show');
    $(window).scrollTop(scrollTop);
    return setTimeout(function() {
      overlay.removeClass('show');
      return setTimeout(function() {
        return overlay.remove();
      }, 200);
    }, 200);
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
  if (sessionStorage.getItem('hide-alert')) {
    alert.remove();
  } else {
    alert.addClass('show');
  }
  body.on('click', '#alert .x', function() {
    sessionStorage.setItem('hide-alert', true);
    return alert.remove();
  });
  $(window).resize(function() {
    return $(window).scroll();
  }).resize();
  $('body').on('click', 'a.subscribe', function(e) {
    e.preventDefault();
    return $('#subscribe').toggleClass('show');
  });
  $('body').on('focus', 'a.subscribe, #subscribe *', function(e) {
    return $('#subscribe').addClass('show');
  });
  $('body').on('click', function(e) {
    if ($(e.target).is('a.subscribe')) {
      return;
    }
    if (e.target.id === 'subscribe') {
      return;
    }
    if ($(e.target).parents('#subscribe').length) {
      return;
    }
    return $('#subscribe').removeClass('show');
  });
  $('#subscribe form').submit(function(e) {
    var data, form, message;
    e.preventDefault();
    form = $(this);
    message = form.find('.message');
    data = $(this).serializeObject();
    form.removeClass('error success');
    message.html('');
    return $.ajax({
      url: this.action,
      method: this.method,
      dataType: 'json',
      data: data,
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(jqXHR, textStatus, errorThrown);
        form.addClass('error');
        if (data.result) {
          return message.html('Sorry, an error has occurred.');
        }
      },
      success: function(data, textStatus, jqXHR) {
        console.log(data, textStatus, jqXHR);
        form.addClass(data.status);
        if (data.result) {
          return message.html(data.result);
        }
      }
    });
  });
  $.fn.serializeObject = function() {
    var a, o;
    o = {};
    a = this.serializeArray();
    $.each(a, function() {
      if (o[this.name]) {
        if (!o[this.name].push) {
          o[this.name] = [o[this.name]];
        }
        return o[this.name].push(this.value || '');
      } else {
        return o[this.name] = this.value || '';
      }
    });
    return o;
  };
  checkIdentity = function() {
    if (sessionStorage.getItem('hide-identity')) {
      identity.remove();
      return body.addClass('header-fixed');
    } else {
      return identity.addClass('show');
    }
  };
  isMobile = function() {
    var size;
    size = body.css('content').replace(/"/g, '');
    if (size === 'mobile') {
      return true;
    }
    return false;
  };
  fixMobileView = function() {
    if (isMobile() && itemsLoop.filter('#events-loop').length) {
      itemsLoop.attr('data-view', 'grid');
      $('.toggle[data-view="grid"]').addClass('active');
      return $('.toggle[data-view="list"]').removeClass('active');
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
    $('[data-view="grid"] .fix-header, [data-view="list"] .list-header').each(function() {
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
      if ($('#identity').length) {
        identity.remove();
        $(window).scrollTop(0);
      }
      body.addClass('header-fixed');
      return mainInner.css({
        marginTop: topHeight
      });
    } else {
      return body.removeClass('header-fixed');
    }
  }).scroll();
  fixMobileView();
  setupGallery();
  if (itemsLoop.is('#events-loop')) {
    fillEventsRows();
    return getEventsBlocks();
  }
});
