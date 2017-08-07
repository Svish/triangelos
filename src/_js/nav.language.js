// If on one of our dev sites
if(Site.TestHosts.indexOf(window.location.host) >= 0)
	// Use cookie host switching
	$('a.language', '#language-bar')
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
		
