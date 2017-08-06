{{% BLOCKS }}
{{< layout }}
{{$ title }}{{album.title}} - {{#_}}title/Music{{/_}}{{/ title }}
{{$ content}}


{{#album}}

	<h1 class="title">{{title}}
		<span>{{#_}}title/Album{{/_}}</span>
	</h1>

	<section class="meta frames no-select">

		<a href="{{PATH}}#the-cover">
			<img class="loading" alt="{{#_}}Album cover{{/_}}" src="i/75x50/album/{{id}}/cover">
		</a>

		<a class="p" href="shop/{{id}}">{{#svg}}cart{{/svg}}</a>
		
		<p>
			<b>{{#_}}Released{{/_}}</b>
			<br>
			{{released | f.date-long}}
		</p>
		<p>
			<b>{{#_}}Spor{{/_}}</b>
			<br>
			{{trackCount}}
		</p>
		<p>
			<b>{{#_}}Total duration{{/_}}</b>
			<br>
			{{totalTime | f.duration}}
		</p>
	</section>

	{{> toc}}


	<section>{{{description | md}}}</section>

	{{> music/the-songs}}

	{{> music/the-credits}}

	{{> music/the-choir}}

	{{> music/the-cover}}
{{/album}}


{{! TODO: >jplayer}}


{{/ content}}
{{/ layout }}
