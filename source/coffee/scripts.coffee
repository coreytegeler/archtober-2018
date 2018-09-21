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
	eventsPool = $('#events-pool')

	getEventsBlocks = () ->
		$.ajax
			url: ajax_obj.ajaxurl,
			type: 'POST',
			dataType: 'html',
			data:
				action: 'get_events_blocks'
			success: (html) ->
				fillEventsBlocks($(html).filter('.event'))
			error: (jqXHR, textStatus, errorThrown) ->
				console.log jqXHR, textStatus, errorThrown
		
	fillEventsBlocks = (blocks) ->
		blocks.each (i, block) ->
			block = $(block)
			days = $(block).attr('data-days').split(',')
			for day in days
				if day != 1 && day != '1'
					dayLoop = $('.day-loop[data-day="'+day+'"]')
					dayLoop.addClass('show')
					dayLoop.append(block.clone())

	fillEventsRows = () ->
		$.ajax
			url: ajax_obj.ajaxurl,
			type: 'POST',
			dataType: 'html',
			data:
				action: 'get_events_rows'
			success: (html) ->
				listView.append(html)
				filterItems()
			error: (jqXHR, textStatus, errorThrown) ->
				console.log jqXHR, textStatus, errorThrown
			
	identity.on 'click', () ->
		top = $(this).innerHeight()
		$('html, body').animate
			scrollTop: top+'px'
		, 200, () ->
			identity.remove()
			$(window).scrollTop(0)


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


	body.on 'click', '.date-header .arrow', () ->
		direction = $(this).attr('data-direction')
		day = $(this).parents('.day-loop')
		if direction == 'next'
			targetDay = day.next()
		else if direction == 'prev'
			targetDay = day.prev()
		else
			return
		targetDate = targetDay.find('.date-header')
		targetTop = targetDate.offset().top - header.innerHeight() + 5
		$('html, body').animate
			scrollTop: targetTop+'px'
		, 200


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
			$(window).scroll()
			filterItems()
		else if filter
			slug = toggle.attr('data-slug')
			if slug != 'clear'
				toggle.toggleClass('active')
			if !toggles.filter('.active').length || slug == 'clear'
				toggles.addClass('active secret')
			filterItems()
		else if $(this).is('.hide-past')
			$(this).toggleClass('active')
			itemsLoop.toggleClass('hide-past')

	filterItems = () ->
		filters = []
		view = itemsLoop.attr('data-view')
		if view == 'grid' && isMobile()
			toggles = $('header .toggle.filter')
			items = itemsLoop.find('.item.block')
		else if view == 'list'
			if itemsLoop.is('#events-loop')
				toggles = $('.list-header .toggle.filter')
			else if itemsLoop.is('#partners-loop')
				toggles = $('.header-row .toggle.filter')
			items = itemsLoop.find('.item-row')

		if toggles
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
		id = item.attr('data-id')
		if !id
			return
		if item.is('.no-gallery')
			overlayPlaceholder.addClass('no-gallery')
		overlayPlaceholder.find('.x').attr('href', location.href)
		if item.is('.event_type-botd')
			overlayPlaceholder.addClass('botd')
		else
			overlayPlaceholder.removeClass('botd')
		overlayPlaceholder.addClass('show')
		url = this.href
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
		$.ajax
			url: ajax_obj.ajaxurl,
			type: 'POST',
			dataType: 'html',
			data:
				id: id,
				post_type: postType,
				action: 'get_overlay'
			success: (html) ->
				body.addClass('overlay-open')
				main.prepend(html)
				setupGallery()
				setTimeout () ->
					main.find('.overlay:not(.placeholder)').addClass('show')
				, 200
				header.removeClass('open')
			error: (error) ->
				console.log error
				closeOverlay()

	closeOverlay = () ->
		body.removeClass('overlay-open')
		overlay = $('.overlay[data-id]')
		id = overlay.attr('data-id')
		item = $('.item').filter('[data-id="'+id+'"]')
		overlayPlaceholder.removeClass('no-gallery')
		if !item.length
			overlay.removeClass('show')
			overlayPlaceholder.removeClass('show')
			setTimeout () ->
				overlay.remove()
			, 200
			return
		parent = item.parents('.loop')
		offset = header.innerHeight()
		if parent.attr('data-view') == 'grid' || parent.is('.exhibitions-loop')
			target = item.parents('.row')
		else
			target = item.filter('.item-row')
			offset += $('.list-header .fix').innerHeight()
		scrollTop = target.offset().top - offset
		overlayPlaceholder.removeClass('show')
		$(window).scrollTop(scrollTop)
		setTimeout () ->
			overlay.removeClass('show')
			setTimeout () ->
				overlay.remove()
			, 200
		, 200


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


	if sessionStorage.getItem('hide-alert')
		alert.remove()
	else
		alert.addClass('show')

	body.on 'click', '#alert .x', () ->
		sessionStorage.setItem('hide-alert', true)
		alert.remove()

	$(window).resize () ->
		$(window).scroll()
	.resize()

	$('body').on 'click', 'a.subscribe', (e) ->
		e.preventDefault()
		$('#subscribe').toggleClass('show')

	$('body').on 'focus', 'a.subscribe, #subscribe *', (e) ->
		$('#subscribe').addClass('show')


	$('body').on 'click', (e) ->
		if $(e.target).is('a.subscribe')
			return
		if e.target.id == 'subscribe'
			return
		if $(e.target).parents('#subscribe').length
			return
		$('#subscribe').removeClass('show')


	$('#subscribe form').submit (e) ->
		e.preventDefault()
		form = $(this)
		message = form.find('.message')
		data = $(this).serializeObject()
		form.removeClass('error success')
		message.html('')
		$.ajax
			url: this.action
			method: this.method
			dataType: 'json'
			data: data
			error: (jqXHR, textStatus, errorThrown) ->
				console.log jqXHR, textStatus, errorThrown
				form.addClass('error')
				if data.result
					message.html('Sorry, an error has occurred.')
			success: (data, textStatus, jqXHR) ->
				console.log data, textStatus, jqXHR
				form.addClass(data.status)
				if data.result
					message.html(data.result)
					

			
	$.fn.serializeObject = () ->
		o = {}
		a = this.serializeArray()
		$.each a, () ->
			if(o[this.name])
				if (!o[this.name].push)
					 o[this.name] = [o[this.name]]
				o[this.name].push(this.value || '')
			else
				o[this.name] = this.value || ''
		return o


	checkIdentity = () ->
		if sessionStorage.getItem('hide-identity')
			identity.remove()
			body.addClass('header-fixed')
		else
			identity.addClass('show')

	isMobile = () ->
		size = body.css('content').replace(/"/g,'')
		if size == 'mobile'
			return true
		return false

	fixMobileView = () ->
		if isMobile() && itemsLoop.filter('#events-loop').length
			itemsLoop.attr('data-view','grid')
			$('.toggle[data-view="grid"]').addClass('active')
			$('.toggle[data-view="list"]').removeClass('active')


	$(window).scroll (e) ->
		checkIdentity()
		scrollTop = $(window).scrollTop()
		mainTop = main.offset().top
		headerHeight = header.innerHeight()
		headerBottom = headerHeight
		topHeight = headerHeight

		$('[data-view="grid"] .fix-header, [data-view="list"] .list-header').each () ->
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
			if $('#identity').length
				identity.remove()
				$(window).scrollTop(0)
			body.addClass('header-fixed')
			mainInner.css
				marginTop: topHeight
		else
			body.removeClass('header-fixed')
	.scroll()

	fixMobileView()

	setupGallery()
	if itemsLoop.is('#events-loop')
		fillEventsRows()
		getEventsBlocks() 