{{% BLOCKS }}
{{< layout }}
{{$ title }}{{track.title | first}} - {{#_}}title/Music{{/_}}{{/ title }}
{{$ content}}

{{#track}}

	<h1><a href="music/album/{{album_id}}">{{album}}</a>
		<span>{{#_}}title/Track{{/_}}</span>
	</h1>

	<ol class="tracks" start="{{track}}">
		<li>
			<span class="length" data-url="music/album/{{file}}">{{seconds | f.duration}}</span>
			<a class="title" href="music/album/{{id}}" type="{{mime}}">{{title | first}}</a>
		</li>
	</ol>
	
	<blockquote class="lyrics">{{{lyrics}}}</blockquote>
	
	<section>{{{html}}}</section>

{{/track}}

{{! TODO: >jplayer}}


{{/ content}}
{{/ layout }}
