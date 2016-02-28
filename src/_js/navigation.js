/**
 * Handles navigation, TOC creation and soft scrolling.
 */
var Navigation = {

	init: function()
	{
		// Menu toggle button
		$('#menu-toggle')
			.click(Navigation.onMenuToggle);


		// Mark current menu item
		$('a', '#header').each(function() {
			var href = $(this).attr('href');
			var current = Site.Url.Current.includes(href) || href.includes(Site.Url.Host);
			$(this).toggleClass('current', current);
		});


		// Cookie language switcher for dev env
		if(['localhost','triangelos.geekality.net'].indexOf(window.location.host) >= 0)
		$('a.language', '#language-menu')
			.on('click', function()
			{
				var host = $(this).data('host');
				var age = 24*60*60;
				document.cookie = 'host='+host
					+'; path='+Site.Url.Base
					+'; max-age='+age;
				window.location.reload();
				return false;
			});


		// Elements with more details
		$('.has-details', '#content').click(Navigation.onDetailsClick);
		$('.details', '#content')
			.click(Navigation.onDetailsOutsideClick)
			.find('article')
			.click(Navigation.doNothing)
			.find('.close')
			.click(Navigation.onDetailsCloseClick);
	},

	doNothing: function(event)
	{
		event.stopPropagation();
	},

	onMenuToggle: function()
	{
		$('#header')
			.toggleClass('menu-open')
			.find('ul')
			.slideToggle();
		return false;
	},

	onDetailsClick: function()
	{
		var details = $(this).data('details');

		$('.details[data-details="'+details+'"]')
			.find('article')
			.andSelf()
			.slideDown();
	},

	onDetailsOutsideClick: function()
	{
		$(this)
			.find('article')
			.scrollTop(0)
			.andSelf()
			.slideUp();
	},

	onDetailsCloseClick: function()
	{
		$(this)
			.closest('.details')
			.click();
	}
};
$(Navigation.init);
