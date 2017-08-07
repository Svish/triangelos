{{% BLOCKS }}
{{< layout }}
{{$ title }}{{#_}}title/Contact{{/_}}{{/ title }}

{{$ content}}



<h1>{{#_}}title/Contact{{/_}}</h1>

{{#practice}}

	{{#md}}{{/md}}

	<section id="gmap_canvas"></section>
	<script type='text/javascript'>function init_map()
	{
		map = new google.maps.Map(document.getElementById('gmap_canvas'),
			{
				zoom:16,
				center: new google.maps.LatLng( {{lat}} , {{lon}} ),
				mapTypeId: google.maps.MapTypeId.ROADMAP,
				mapTypeControl: false,
				streetViewControl: false,
				scrollwheel: false,
			});

		marker = new google.maps.Marker(
			{
				map: map,
				position: new google.maps.LatLng( {{lat}} , {{lon}} ),
				title: '{{label}}',
			});

		google.maps.event.addDomListener(window, 'resize', function()
			{
				map.setCenter(marker.position);
			});
	}
	</script>
	<script async defer src="https://maps.googleapis.com/maps/api/js?callback=init_map&amp;key={{google.api_key}}"></script>
{{/practice}}

<section class="flex">

	<section>
		<h2>{{#_}}title/Mail{{/_}}</h2>
		<address>{{post}}</address>
	</section>

	<section>
		<h2>{{#_}}title/Bank details{{/_}}</h2>
		<address>{{bank}}</address>
	</section>

	<section>
		<h2>{{#_}}title/Social{{/_}}</h2>
		<div class="p">

			{{>button-youtube}}

			{{>button-facebook}}

		</div>
	</section>

</section>

<section>
	<h2>{{#_}}title/E-Mail{{/_}}</h2>
	{{> contact/email-form }}
</section>



{{/ content}}

{{/ layout }}
