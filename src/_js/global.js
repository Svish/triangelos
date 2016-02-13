
$(function()
{
	// Mark current menu item
	$('[href='+Site.Url.Current+']').addClass('current');
	// TODO: Mark current language

	if(window.location.host == 'localhost' || true) // TODO: Remove true when proper hosted
	$('a', '#language-selector')
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
