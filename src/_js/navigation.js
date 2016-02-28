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
	},

	onMenuToggle: function()
	{
		$('#header')
			.toggleClass('menu-open')
			.find('ul')
			.slideToggle();
		return false;
	},
};
$(Navigation.init);
