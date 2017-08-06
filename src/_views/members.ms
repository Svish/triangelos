{{% BLOCKS }}
{{< layout }}
{{$ title }}{{#_}}title/Members{{/_}}{{/ title }}

{{$ content}}



<h1>{{#_}}title/Members{{/_}}</h1>

<div class="center frames no-select">
	{{#members}}
		{{> user/badge }}
	{{/members}}
</div>



{{/ content}}

{{/ layout }}
