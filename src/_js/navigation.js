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
		{
			var parts = Site.Url.Current.split('/');

			do
			{
				$("a[href='" + parts.join('/') + "']", '#main-menu')
					.addClass('current');
				parts.pop();
			}
			while(parts.length);
		}


		// Mark current language
		$('a', '#language-menu').each(function()
		{
			var href = $(this).attr('href');
			var current = href.includes(Site.Url.Host);
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
