jQuery(document).ready ($) ->
	title = $('nav .title')
	archive = $('nav .archive')
	years = $('nav .years')
	archive.find('a').on 'click', (e) ->
		years.toggleClass('show')

	$(window).resize () ->
		if title.find('.label').innerHeight() > archive.find('.label').innerHeight()
			years.addClass('static')
		else
			years.removeClass('static')
	.resize()

