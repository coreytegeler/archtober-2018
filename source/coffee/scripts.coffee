jQuery(document).ready ($) ->
	body = $('body')
	nav = $('nav')
	header = $('header')
	headerPlaceholder = $('.header-placeholder')
	identity = $('#identity')
	intro = $('#intro')
	alert = $('#alert')
	main = $('main')
	mainInner = $('.main-inner')
	burger = $('.burger')
	overlayPlaceholder = $('.overlay.placeholder')
	itemsLoop = $('.loop')
	itemRows = $('.item-row')
	gridView = itemsLoop.find('.grid-view') 
	listView = itemsLoop.find('.list-view') 

	fillDays = () ->
		$('.grid-view .day-loop').each (i, gridDayLoop) ->
			date = $(gridDayLoop).attr('data-date')
			$.ajax
				url: ajax_obj.ajaxurl,
				type: 'POST',
				dataType: 'html',
				data:
					date: date,
					action: 'get_day_of_events'
				success: (html) ->
					if html.length
						$(gridDayLoop).find('.block.placeholder').remove()
						blocks = $(html).filter('.event-block')
						rows = $(html).filter('.event-row')
						blocks.each (i, block) ->
							$(gridDayLoop).append(block)
						$(gridDayLoop).addClass('show')
						listDayLoop = listView.find('[data-date="'+date+'"]')
						rows.each (i, row) ->
							listDayLoop.append(row)
						if itemsLoop.attr('data-view') == 'list'
							filterItems()
				error: (error) ->
					console.log error
			
	identity.on 'click', () ->
		top = $(this).position().top + $(this).innerHeight()
		$('html, body').animate
			scrollTop: top+'px'
		, 200


	body.on 'click', '.nav-icon.burger', () ->
		nav.addClass('open')
		body.addClass('header-open')
		$(window).scroll()

	body.on 'click', '.nav-icon.x', () ->
		nav.removeClass('open')
		body.removeClass('header-open')
		$(window).scroll()

	body.on 'click', '.menu-item.archive span', () ->
		$(this).toggleClass('active')
		$('.menu-item.year').each (i, item) ->
			setTimeout () ->
				$(item).toggleClass('show')
			, i*50

	body.on 'click', '.calendar .clear', () ->
		$('.calendar .day').addClass('active secret')
		filterItems()

	body.on 'click', '.header-row .label.mobile', () ->
		header.toggleClass('show-toggles')

	body.on 'click', '.sort-header', () ->
		col = $(this).parents('.col-header')
		sort = col.attr('data-sort')


	body.on 'click', '.toggle', () ->
		toggle = $(this)
		view = toggle.attr('data-view')
		filter = toggle.attr('data-filter')
		toggles = toggle.parents('.toggles').find('.toggle')
		toggles.filter('.secret').each (i, secret) ->
			$(secret).removeClass('active secret')
	
		if view
			sib = toggle.siblings('.view')
			sib.removeClass('active')
			$('.events-loop').attr('data-view', view)
			toggle.addClass('active')
		else if filter
			toggle.toggleClass('active')
			if !toggles.filter('.active').length
				toggles.addClass('active secret')
			filterItems()
		else if $(this).is('.hide-past')
			$(this).toggleClass('active')
			itemsLoop.toggleClass('hide-past')

	filterItems = () ->
		filters = []
		view = itemsLoop.attr('data-view')
		if view == 'grid'
			toggles = $('header .toggle.filter')
			items = itemsLoop.find('.item.block')
		else if view == 'list'
			if itemsLoop.is('#events-loop')
				toggles = $('.list-header .toggle.filter')
			else if itemsLoop.is('#partners-loop')
				toggles = $('.header-row .toggle.filter')
			items = itemsLoop.find('.item-row')
		toggles.each (i, toggle) ->
			filter = $(toggle).attr('data-filter')
			slug = $(toggle).attr('data-slug')
			selector = '.'+filter+'-'+slug
			if !filters[filter]
				filters.push(filter)
				filters[filter] = []
			if $(toggle).is('.active')
				filters[filter].push(slug)
		items.removeClass('hide')
		for tax in filters
			selected = filters[tax]			
			items.each (i, item) ->
				terms = $(item).attr('data-'+tax)
				if terms
					terms = terms.split(',')
					show = false
					for term in terms
						if selected.indexOf(term) >= 0
							show = true
					if !show
						$(item).addClass('hide')

	body.on 'click', '.item-link', (e) ->
		e.preventDefault()
		item = $(this).parents('.item')
		overlayPlaceholder.find('.x').attr('href', location.href)
		if item.is('.event_type-botd')
			overlayPlaceholder.addClass('botd')
		else
			overlayPlaceholder.removeClass('botd')
		overlayPlaceholder.addClass('show')
		url = this.href
		id = item.attr('data-id')
		postType = item.attr('data-post-type')
		state =
			action: 'open'
			url: window.location.href,
			postType: postType,
			id: id
		history.pushState(state, null, url);
		openOverlay(id, postType)

	body.on 'click', '.overlay .x', (e) ->
		e.preventDefault()
		url = this.href
		state =
			action: 'close'
		history.pushState(state, null, url);
		overlay = $(this).parents('.overlay')
		closeOverlay()

	body.on 'click', '#alert .x', (e) ->
		$('#alert').remove()

	window.onpopstate = () ->
		if !history.state
			return
		if history.state.action == 'open'
			openOverlay(history.state.id, history.state.postType)
		else if history.state.action == 'close'
			closeOverlay()

	openOverlay = (id, postType) ->
		body.addClass('overlay-open')
		$.ajax
			url: ajax_obj.ajaxurl,
			type: 'POST',
			dataType: 'html',
			data:
				id: id,
				post_type: postType,
				action: 'get_overlay'
			success: (html) ->
				main.prepend(html)
				setupGallery()
				overlayPlaceholder.removeClass('show')
				header.removeClass('open')
			error: (error) ->
				console.log error
				closeOverlay()

	closeOverlay = () ->
		body.removeClass('overlay-open')
		overlay = $('.overlay[data-id]')
		id = overlay.attr('data-id')
		if !id
			overlay.removeClass('show')
			overlayPlaceholder.removeClass('show')
			return
		item = $('.item').filter('[data-id="'+id+'"]')
		parent = item.parents('.loop')
		offset = header.innerHeight()
		if parent.attr('data-view') == 'grid' || parent.is('.exhibitions-loop')
			target = item.parents('.row')
		else
			target = item.filter('.item-row')
			offset += $('.list-header .fix').innerHeight()
		scrollTop = target.offset().top - offset
		$(window).scrollTop(scrollTop)
		overlay.remove()


	body.on 'click', '.gallery .dot', (e) ->
		index = $(this).attr('data-index')
		gallery = $(this).parents('.gallery')
		figure = gallery.find('figure[data-index="'+index+'"]')
		dot = gallery.find('.dot[data-index="'+index+'"]')
		caption = gallery.find('figcaption[data-index="'+index+'"]')
		if !figure
			return
		gallery.find('.active').removeClass('active')
		dot.addClass('active')
		caption.addClass('active')
		figure.addClass('active')


	setupGallery = () ->
		gallery = $('.gallery')
		images = gallery.find('img')
		images.imagesLoaded().progress ( instance, image ) ->
			$img = $(image.img)
			result = image.isLoaded ? 'loaded' : 'broken'
			figure = $img.parent()
			figure.addClass('loaded')


	if localStorage.getItem('hide-alert')
		alert.remove()
	else
		alert.addClass('show')

	body.on 'click', '#alert .x', () ->
		localStorage.setItem('hide-alert', true)
		alert.remove()

	$(window).resize () ->
		$(window).scroll()
	.resize()


	checkIdentity = () ->
		if sessionStorage.getItem('hide-identity')
			identity.remove()
			body.addClass('header-fixed')
		else
			identity.addClass('show')

	$(window).scroll (e) ->
		checkIdentity()
		scrollTop = $(window).scrollTop()
		mainTop = main.offset().top
		headerHeight = header.innerHeight()
		headerBottom = headerHeight
		topHeight = headerHeight

		$('[data-view="grid"] .date-header, [data-view="list"] .list-header').each () ->
			thisHeader = $(this)
			thisFix = thisHeader.find('.fix')
			thisTop = thisHeader.offset().top
			fixHeight = thisFix.innerHeight()
			if thisTop <= scrollTop + headerBottom
				thisHeader.addClass('fixed').css
					height: fixHeight
				thisFix.css
					top: headerBottom
			else
				thisHeader.removeClass('fixed').attr('style','')
				thisFix.attr('style','')

		if !topHeight
			topHeight = headerHeight

		if mainTop <= scrollTop
			sessionStorage.setItem('hide-identity', true)
			identity.remove()
			mainInner.css
				marginTop: topHeight
			body.addClass('header-fixed')
		else
			body.removeClass('header-fixed')

	.scroll()

	setupGallery()
	fillDays()