
$(function()
{
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



if(typeof String.prototype.contains === 'undefined')
String.prototype.contains = function(it)
{
	return this.indexOf(it) != -1;
};
