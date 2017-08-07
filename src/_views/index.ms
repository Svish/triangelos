{{% BLOCKS }}
{{< layout }}
{{$ title }}🙂{{/ title }}

{{$ content}}


<section class="albums">
	<h2><a href="music">{{#_}}title/Check our latest albums{{/_}} {{#svg}}jumping-man{{/svg}}</a></h2>
	{{#albums}}
	<a class="block loading album" href="{{ . | url}}">
		<img width="100" class="frame" alt="{{#_}}Album cover{{/_}}" src="i/120x250/album/{{id}}/cover">
		<div class="title">{{title}}</div>
		<time datetime="{{released | f.w3c}}">{{released | f.year}}</time>
	</a>
	{{/albums}}
</section>


<section class="events">
	<h2><a href="calendar">{{#_}}title/Come see us live{{/_}} {{#svg}}people{{/svg}}</a></h2>
	<pre>// TODO</pre>
	{{#calendar.up_next}}
	<a class="block event" href="calendar#{{iso}}">
		<div class="title">{{summary|_}}</div>
		<time datetime="{{start|f.w3c}}">{{start|df.date-short}}{{^all_day}}, {{end|df.time}}{{/all_day}}</time>
		<address>{{{location | firstLine}}}</address>
	</a>
	{{/calendar.up_next}}
</section>


<section class="posts">
	<h2><a href="https://www.facebook.com/triangelos">{{#_}}title/Follow us on Facebook{{/_}} {{#svg}}share{{/svg}}</a></h2>
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