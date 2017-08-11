{{% BLOCKS }}
{{< layout }}
{{$ title }}🙂{{/ title }}

{{$ content}}

<pre>// TODO: Section flex, Dynamic SVG image, ...</pre>

<section class="albums">
	<h2><a href="music">{{#svg}}woman-listening-to-music{{/svg}} {{#_}}title/Check our latest albums{{/_}}</a></h2>
	{{#albums}}
	<a class="block loading album" href="{{ . | url}}">
		<img width="100" class="frame" alt="{{#_}}Album cover{{/_}}" src="i/100x150/album/{{id}}/cover">
		<div class="title">{{title}}</div>
		<time datetime="{{released | f.w3c}}">{{released | f.year}}</time>
	</a>
	{{/albums}}
</section>


<section class="events">
	<h2><a href="calendar">{{#svg}}jumping-man{{/svg}} {{#_}}title/Listen to us live{{/_}}</a></h2>
	{{#events}}
	<a class="block event" href="calendar/event/{{uid}}">
		<img width="100" class="frame" alt="" src="https://placehold.it/100x100">
		<div class="title">{{summary | _.cal}}</div>
		<time datetime="{{start|f.w3c}}">{{start|f.date}}{{^all_day}}, {{end|f.time}}{{/all_day}}</time>
		<address>{{{location | fl}}}</address>
	</a>
	{{/events}}
</section>


<section class="posts">
	<h2><a href="https://www.facebook.com/triangelos">{{#svg}}facebook{{/svg}} {{#_}}title/Follow us on Facebook{{/_}}</a></h2>
	{{#facebook}}
	<a class="block post loading" href="{{link}}">
		{{#picture}}<img width="100" class="frame" src="{{.}}">{{/picture}}
		<div class="title">{{text | fl}}</div>
		<time datetime="{{created_time}}">{{created_time | f.full}}</time>
		<div class="description">{{description}}</div>
		<div class="text">{{text | flr}}</div>
	</a>
	{{/facebook}}
</section>


{{/ content}}

{{/ layout }}
