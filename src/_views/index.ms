{{% BLOCKS }}
{{< layout }}
{{$ title }}🙂{{/ title }}

{{$ content}}

<div class="flex">

<section class="albums">
	<h2><a href="music">{{#_}}Get our latest albums{{/_}} {{#svg}}jumping-man{{/svg}}</a></h2>
	<pre>// TODO</pre>
	{{#music.latest}}
	<a class="block album" href="{{url}}">
		<img width="100" class="frame" alt="{{#_}}Album cover{{/_}}" src="i/100x150/{{images.cover}}">
		{{title}}
		<br>
		{{year}}
	</a>
	{{/music.latest}}
</section>


<section class="events">
	<h2><a href="calendar">{{#_}}Come see us live{{/_}} {{#svg}}people{{/svg}}</a></h2>
	<pre>// TODO</pre>
	{{#calendar.up_next}}
	<a class="block event" href="calendar#{{iso}}">
		{{summary|_}}
		<br>
		<time datetime="{{start|df.w3c}}">{{start|df.date-short}}{{^all_day}}, {{end|df.time}}{{/all_day}}</time>
		{{#location}}
		<br>
		<address>{{{location | firstLine}}}</address>
		{{/location}}
	</a>
	{{/calendar.up_next}}
</section>


<section class="posts">
	<h2><a href="https://www.facebook.com/triangelos">{{#_}}Follow us on Facebook{{/_}} {{#svg}}share{{/svg}}</a></h2>
	<pre>// TODO</pre>
	{{#facebook.latest}}
	<a class="block post" href="{{link}}">
		{{#picture}}<img width="100" class="frame" src="{{.}}">{{/picture}}
		{{text}}
		<br>
		<time datetime="{{created_time}}">{{created_time | df.full}}</time>
		{{#description}}<br>{{.}}{{/description}}
	</a>
	{{/facebook.latest}}
</section>

</div>


{{/ content}}

{{/ layout }}
