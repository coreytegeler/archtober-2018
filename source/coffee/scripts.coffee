jQuery(document).ready ($) ->
	mobileNav = $('header.mobile nav')
	burger = $('.burger')
	title = $('nav .title')
	archive = $('nav .archive')
	years = $('nav .years')
	headersMobile = $('.headers-mobile')

	archive.on 'click', (e) ->
		nav = $(this).parents('nav')
		years = nav.find('.years')
		years.toggleClass('show')
		header = nav.parents('header')
		$(window).resize()
		if header.length
			height = title.innerHeight()
			if years.is('.show')
				height = nav.find('.title').innerHeight() + years.innerHeight() + 15
			else
				height = 'auto'
			header.css
				height: height

	burger.on 'click', (e) ->
		mobileNav.toggleClass('show')

	$(window).resize () ->
		if title.find('.label').innerHeight() > archive.find('.label').innerHeight()
			years.addClass('static')
		else
			years.removeClass('static')
		$(window).scroll()
	.resize()


	$(window).scroll (e) ->
		headersMobileTop = headersMobile.position().top - $(window).scrollTop()
		if headersMobileTop <= 0
			headersMobile.addClass('passed')
		else
			headersMobile.removeClass('passed')
	.scroll()

