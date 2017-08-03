{{% BLOCKS }}
{{< layout }}
{{$ title }}{{#_}}title/Video{{/_}}{{/ title }}
{{$ content}}



<h1><a href="{{PATH}}">{{#_}}title/Video{{/_}}</a></h1>


<div class="center frames p">
	{{> video/video }}
</div>

<div class="center">{{> contact/button-youtube}}



{{/ content}}
{{/ layout }}
