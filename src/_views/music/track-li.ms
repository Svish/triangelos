
<li>
	<span class="file length" data-url="{{ . | url}}.mp3">{{duration.number | f.duration}}</span>
	<a class="title" href="{{ . | url}}">{{title | first}}</a>
</li>
