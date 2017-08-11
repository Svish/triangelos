{{% BLOCKS }}
{{< layout }}
{{$ title }}{{event.summary | _.cal}} - {{#_}}title/Calendar{{/_}}{{/ title }}
{{$ content}}


{{#event}}

	<h1>{{summary | _.cal}}
		<span>{{#_}}title/Event{{/_}}</span>
	</h1>

<pre>// TODO: Status, Public/Private, Translate rrule, ...</pre>

	<section>{{{description | md}}}</section>

	<section class="flex p">

		{{^rrule}}
		<div>
			<h2>{{#_}}cal/When{{/_}}</h2>
			<p><b>{{#_}}cal/From{{/_}}: </b>
				<time datetime="{{start|f.w3c}}">
					{{#day}}
					{{start|f.date-long}}
					{{/day}}
					{{^day}}
					{{start|f.full-long}}
					{{/day}}
				</time>
				<br>
				<b>{{#_}}cal/To{{/_}}: </b>
				<time datetime="{{end|f.w3c}}">
					{{#day}}
					{{end|f.date-long}}
					{{/day}}
					{{^day}}
					{{end|f.full-long}}
					{{/day}}
				</time>
		</div>
		{{/rrule}}


		{{#rrule}}
		<div>
			<h2>{{#_}}cal/When{{/_}}</h2>
			<p>{{. | f.rrule | ucfirst}}
		</div>
		{{/rrule}}


		{{#location}}
		<div>
			<h2>{{#_}}cal/Where{{/_}}</h2>
			<address>{{.}}</address>
		</div>
		{{/location}}

	</section>

	{{#location}}
	<section id="gmap_canvas"></section>
	<script type='text/javascript'>

		function init()
		{
			var geo = new google.maps.Geocoder();
			geo.geocode({
				address: '{{. | f.addressLine}}',
				language: 'no',
				region: 'no',
				}, init_map);
		}

		function init_map(result, status)
		{
			if(status !== 'OK')
			{
				console.error(status, result);
				return;
			}

			var lat = result[0].geometry.location.lat();
			var lng = result[0].geometry.location.lng();

			map = new google.maps.Map(document.getElementById('gmap_canvas'),
				{
					zoom:16,
					center: new google.maps.LatLng(lat, lng),
					mapTypeId: google.maps.MapTypeId.ROADMAP,
					mapTypeControl: true,
					streetViewControl: false,
					scrollwheel: false,
				});

			marker = new google.maps.Marker(
				{
					map: map,
					position: new google.maps.LatLng(lat, lng),
					title: '{{location | fl}}',
				});

			google.maps.event.addDomListener(window, 'resize', function()
				{
					map.setCenter(marker.position);
				});
		}

	</script>
	<script async defer src="https://maps.googleapis.com/maps/api/js?callback=init&amp;key={{google.api_key}}"></script>
	{{/location}}

{{/event}}


{{/ content}}
{{/ layout }}
