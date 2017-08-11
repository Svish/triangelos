{{% BLOCKS }}
{{< layout }}
{{$ title }}{{album.title}} - {{#_}}title/Music{{/_}}{{/ title }}
{{$ content}}


{{#album}}

	<h1>{{title}}
		<span>{{#_}}title/Album{{/_}}</span>
	</h1>
	
	<section class="loading meta frames no-select">
		<a href="{{PATH}}#the-cover">
			<img alt="{{#_}}Album cover{{/_}}" src="i/75x50/album/{{id}}/cover">
		</a>
		<a class="p" href="shop/{{id}}">{{#svg}}cart{{/svg}}</a>
		<p>
			{{#_}}Released{{/_}}
			<br>
			{{released | f.date-long}}
		</p>
		<p>
			{{#_}}Spor{{/_}}
			<br>
			{{trackCount}}
		</p>
		<p>
			{{#_}}Total duration{{/_}}
			<br>
			{{totalTime | f.duration}}
		</p>
	</section>


	<section>{{{description | md}}}</section>

	{{> music/the-songs}}

	{{> music/the-credits}}

	{{> music/the-choir}}

	{{> music/the-cover}}
{{/album}}


{{! TODO: >jplayer}}


{{/ content}}
{{/ layout }}
