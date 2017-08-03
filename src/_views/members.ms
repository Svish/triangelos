{{% BLOCKS }}
{{< layout }}
{{$ title }}{{#_}}title/Members{{/_}}{{/ title }}

{{$ content}}



<h1><a href="{{PATH}}">{{#_}}title/Members{{/_}}</a></h1>

<div class="center frames no-select">
	{{#members}}
		{{> user/badge }}
	{{/members}}
</div>



{{/ content}}

{{/ layout }}
