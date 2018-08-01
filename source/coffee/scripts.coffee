jQuery(document).ready ($) ->
	body = $('body')
	headerWrap = $('.header-wrap')
	header = $('header')
	headerPlaceholder = $('.header-placeholder')
	identity = $('#identity')
	main = $('main')
	burger = $('.burger')
	overlayPlaceholder = $('.overlay.placeholder')
	eventsLoop = $('.events-loop')
	itemRows = $('.item-row')

	fillDays = () ->
		$('.day-loop').each (i, day) ->
			date = $(day).attr('data-date')
			$.ajax
				url: ajax_obj.ajaxurl,
				type: 'POST',
				dataType: 'html',
				data:
					date: date,
					action: 'get_day_of_events'
				success: (html) ->
					if html.length
						$(day).append(html)
						$(day).addClass('show')
					else
						$(day).remove()
				error: (error) ->
					console.log error

			
	identity.on 'click', () ->
		top = $(this).position().top + $(this).innerHeight()
		$('html, body').animate
			scrollTop: top+'px'
		, 200


	$(window).scroll (e) ->
		scrollTop = $(window).scrollTop()
		headerBottom = header.position().top + header.innerHeight()
		identityBottom = identity.innerHeight()
		if identityBottom <= scrollTop
			body.addClass('header-fixed')
			$('.date-header').each () ->
				dateTop = $(this).offset().top
				if dateTop <= scrollTop + headerBottom
					$(this).addClass('fixed')
					$(this).find('.fix').css
						top: headerBottom
				else
					$(this).removeClass('fixed')
		else
			body.removeClass('header-fixed')
			




	.scroll()

	body.on 'click', 'header .burger', () ->
		header.addClass('open')

	body.on 'click', 'header .x', () ->
		header.removeClass('open')

	body.on 'click', '.menu-item.archive', () ->
		$(this).toggleClass('active')
		$('.menu-item.year').each (i, item) ->
			setTimeout () ->
				$(item).toggleClass('show')
			, i*50

	body.on 'click', '.calendar .clear', () ->
		$('.calendar .day').addClass('active secret')
		filterList()

	body.on 'click', '.header-row .label.mobile', () ->
		header.toggleClass('show-toggles')

	body.on 'click', '.toggle', () ->
		view = $(this).attr('data-view')
		filter = $(this).attr('data-filter')
		if $(this).is('.day')
			$('.calendar .filter.secret').removeClass('secret active')
		if view
			sib = $(this).siblings('.view')
			sib.removeClass('active')
			$('.events-loop').attr('data-view', view)
			$(this).addClass('active')
		else if filter
			$(this).toggleClass('active')
			filterList()
		else if $(this).is('.hide-past')
			$(this).toggleClass('active')
			eventsLoop.toggleClass('hide-past')

	filterList = () ->
		filters = []
		$('.toggle.filter').each (i, toggle) ->
			filter = $(toggle).attr('data-filter')
			slug = $(toggle).attr('data-slug')
			selector = '.'+filter+'-'+slug
			if !filters[filter]
				filters.push(filter)
				filters[filter] = []
			if $(toggle).is('.active')
				filters[filter].push(slug)

		itemRows.removeClass('hide')
		for tax in filters
			selected = filters[tax]
			itemRows.each (i, itemRow) ->
				terms = $(itemRow).attr('data-'+tax)
				if terms
					terms = terms.split(',')
					show = false
					for term in terms
						if selected.indexOf(term) >= 0
							show = true
					if !show
						$(itemRow).addClass('hide')


	body.on 'click', '.item-link', (e) ->
		e.preventDefault()
		item = $(this).parents('.item')
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

	closeOverlay = () ->
		overlay = $('.overlay[data-id]')
		id = $(overlay).attr('data-id')
		item = $('.item').filter('[data-id="'+id+'"]')
		if $('.loop').is(['data-view="grid"']) || $('.loop').is('.exhibitions-loop')
			target = item.parents('.row')
		else
			target = item.filter('.item-row')
		scrollTop = target.offset().top - header.innerHeight()
		$(window).scrollTop(scrollTop - 30)
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



	setupGallery()
	fillDays()
		

# 	mobileNav = $('header.mobile nav')
# 	burger = $('.burger')
# 	title = $('nav .title')
# 	archive = $('nav .archive')
# 	years = $('nav .years')
# 	header = $('.headers-mobile')

# 	archive.on 'click', (e) ->
# 		nav = $(this).parents('nav')
# 		years = nav.find('.years')
# 		years.toggleClass('show')
# 		header = nav.parents('header')
# 		$(window).resize()
# 		if header.length
# 			height = title.innerHeight()
# 			if years.is('.show')
# 				height = nav.find('.title').innerHeight() + years.innerHeight() + 15
# 			else
# 				height = 'auto'
# 			header.css
# 				height: height

# 	burger.on 'click', (e) ->
# 		mobileNav.toggleClass('show')

# 	$(window).resize () ->
# 		if title.find('.label').innerHeight() > archive.find('.label').innerHeight()
# 			years.addClass('static')
# 		else
# 			years.removeClass('static')
# 		$(window).scroll()
# 	.resize()


# 	$(window).scroll (e) ->
# 		headerTop = header.position().top - $(window).scrollTop()
# 		if headerTop <= 0
# 			header.addClass('passed')
# 		else
# 			header.removeClass('passed')
# 	.scroll()

