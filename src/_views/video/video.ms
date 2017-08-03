
{{#videos}}
<a class="loading" href="video/{{id}}">
	<div class="thumbnail" data-duration="{{duration | f.duration}}"><img src="{{thumbnail.url}}" width="{{thumbnail.width}}" height="{{thumbnail.height}}"></div>
	<span title="{{title}}">{{title}}</span>
</a>
{{/videos}}
