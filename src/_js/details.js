/**
 * Handles navigation, TOC creation and soft scrolling.
 */
var Details = {

	init: function()
	{
		// Elements with more details
		$('.has-details', '#content').click(Details.onHasDetailsClick);
		$('.details', '#content')
			.click(Details.onDetailsOutsideClick)
			.find('article')
			.click(Details.doNothing)
			.find('.close')
			.click(Details.onDetailsCloseClick);
	},

	onHasDetailsClick: function()
	{
		var details = $(this).data('details');

		$('.details[data-details="'+details+'"]')
			.fadeIn(250);
			//.slideDown()
 			//.find('article')
			//.fadeIn();
	},

	onDetailsOutsideClick: function()
	{
		$(this)
			.fadeOut(250);
			//.slideUp()
			//.find('article')
			//.scrollTop(0)
			//.fadeOut();
	},

	onDetailsCloseClick: function()
	{
		$(this)
			.closest('.details')
			.click();
	},

	doNothing: function(event)
	{
		event.stopPropagation();
	},
};

$(Details.init);
