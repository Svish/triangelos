{{% BLOCKS }}
{{< layout }}
{{$ title }}{{track.title | first}} - {{#_}}title/Music{{/_}}{{/ title }}
{{$ content}}

{{#track}}

	<h1>{{title | first}}
		<span>{{#_}}title/Song{{/_}}</span>
	</h1>

	<section class="meta frames no-select">
		<a href="{{PATH}}#the-cover">
			<img class="loading" alt="{{#_}}Album cover{{/_}}" src="i/75x50/album/{{album_id}}/cover">
		</a>

		<a class="p" href="shop/{{album_id}}">{{#svg}}cart{{/svg}}</a>

		<p>
			<b>{{#_}}Duration{{/_}}</b>
			<br>
			{{duration.number | f.duration}}
		</p>
	</section>

	{{> toc}}
	
	<section>{{{description | md}}}</section>

	{{#lyrics}}
	<section id="the-lyrics" class="toc">
		<h2>{{#_}}title/The lyrics{{/_}}</h2>
		<blockquote class="lyrics">{{{. | md}}}</blockquote>
	</section>
	{{/lyrics}}

	{{> music/the-credits}}
	
	{{#album}}
	{{> music/the-choir}}
	{{/album}}

{{/track}}

{{! TODO: >jplayer}}


{{/ content}}
{{/ layout }}
