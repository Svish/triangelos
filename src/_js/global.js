
$(function()
{
	// Mark current menu item
	$('a', '#header').each(function() {
		var href = $(this).attr('href');
		var current = Site.Url.Current.contains(href) || href.contains(Site.Url.Host);
		$(this).toggleClass('current', current);
	});

	if(window.location.host == 'localhost' || true) // TODO: Remove true when proper hosted
	$('a.language', '#language-selector')
		.on('click', function()
		{
			var host = $(this).data('host');
			var age = 24*60*60;
			document.cookie = 'host='+host
				+'; path='+Site.Url.Base
				+'; max-age='+age;
			window.location.reload();
			return false;
		})


	// Configure NProgress
	NProgress.configure({
		parent: '#header',
		showSpinner: false,
	});

	// Global ajax progress, cause why not
	$(document)
		.ajaxStart(NProgress.start)
		.ajaxStop(NProgress.done);
});
