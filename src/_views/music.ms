{{% BLOCKS }}
{{< layout }}
{{$ title }}{{#_}}title/Music{{/_}}{{/ title }}
{{$ content}}



<h1>{{#_}}title/Music{{/_}}</h1>

{{#albums}}
<article class="album loading">
	<h2 class="title">
		<a href="{{ . | url}}" title="{{#_}}More information…{{/_}}">
			<img class="frame" alt="{{#_}}Album cover{{/_}}" src="i/120x250/album/{{id}}/cover">
			{{title}}
			<span>{{released | f.year}}</span>
			<br>
		</a>
	</h2>

	{{> tracks-ol}}

</article>
{{/albums}}

{{! >jplayer}}


{{/ content}}
{{/ layout }}
