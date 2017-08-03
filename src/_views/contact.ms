{{% BLOCKS }}
{{< layout }}
{{$ title }}{{#_}}title/Contact{{/_}}{{/ title }}

{{$ content}}



<h1><a href="{{PATH}}">{{#_}}title/Contact{{/_}}</a></h1>

{{{md}}}

<div id="gmap_canvas" class="p"></div>
<script type='text/javascript'>function init_map()
{
	map = new google.maps.Map(document.getElementById('gmap_canvas'),
		{
			zoom:16,
			center: new google.maps.LatLng(59.917949,10.744473),
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			mapTypeControl: false,
			streetViewControl: false,
			scrollwheel: false,
		});

	marker = new google.maps.Marker(
		{
			map: map,
			position: new google.maps.LatLng(59.917949,10.744473),
			title: 'Adventkirken Betel',
		});

	google.maps.event.addDomListener(window, 'resize', function()
		{
			map.setCenter(marker.position);
		});
}
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?callback=init_map"></script>


<div class="p flex">

	<section>
		<h2>{{#_}}title/Mail{{/_}}</h2>
		<address><b>Triangelos</b>
			Postboks 102
			1429 Vinterbro
			Norway
		</address>
	</section>

	<section>
		<h2>{{#_}}title/Bank details{{/_}}</h2>
		<p>1720 26 24200<br>
			<small><b>IBAN:</b> NO71 1720 2624 200</small><br>
			<small><b>SWIFT/BIC:</b> BIENNOK1</small>
		</p>
	</section>

	<section>
		<h2>{{#_}}title/Social{{/_}}</h2>
		<div class="p">

			{{>button-youtube}}

			{{>button-facebook}}

		</div>
	</section>

</div>

<section>
	{{> contact/email}}
</section>



{{/ content}}

{{/ layout }}
