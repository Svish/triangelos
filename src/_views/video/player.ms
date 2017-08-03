{{% BLOCKS }}
{{< layout }}
{{$ title }}{{video.title}} - {{#_}}title/Video{{/_}}{{/ title }}
{{$ content}}

{{#video}}
<h1>{{title}}
	<span>{{#_}}title/Video{{/_}}</span>
</h1>

<section class="videowrapper">
	{{{player}}}
</section>
{{/video}}

<section class="center frames">
	{{> video/video }}
</section>


<div class="center">{{> contact/button-youtube }}

{{/ content}}
{{/ layout }}
