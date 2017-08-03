<ol class="tracks">
	{{#tracks}}
	<li>
		<span class="length" data-url="music/album/{{file}}">{{seconds | f.duration}}</span>
		<a class="title" href="music/album/{{id}}" type="{{mime}}">{{title | first}}</a>
	</li>
	{{/tracks}}
</ol>
