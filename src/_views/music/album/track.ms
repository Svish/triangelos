{{% BLOCKS }}
{{< layout }}
{{$ title }}{{track.title | first}} - {{#_}}title/Music{{/_}}{{/ title }}
{{$ content}}


{{#track}}

	<h1>{{title | first}}
		<span>{{#_}}title/Song{{/_}}</span>
	</h1>

	<section class="loading meta frames no-select">
		<a class="p" href="shop/{{album_id}}">{{#svg}}cart{{/svg}}</a>

		<a href="{{PATH}}#the-cover">
			<img alt="{{#_}}Album cover{{/_}}" src="i/75x50/album/{{album_id}}/cover">
		</a>
		<p>
			<b>{{#_}}Duration{{/_}}</b>
			<br>
			{{duration.number | f.duration}}
		</p>
	</section>
	
	<section>{{{description | md}}}</section>

	{{> music/the-credits}}
	
	{{#album}}
	{{> music/the-choir}}
	{{/album}}

	{{> music/the-lyrics}}

{{/track}}

{{! TODO: >jplayer}}


{{/ content}}
{{/ layout }}
