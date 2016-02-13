
$(function()
{
	// Mark current menu item
	$('[href='+Site.Url.Current+']').addClass('current');

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
