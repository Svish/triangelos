{{% BLOCKS }}
{{< layout }}
{{$ title }}{{#_}}title/About the site{{/_}}{{/ title }}

{{$ content}}



<h1>{{#_}}title/About the site{{/_}}</h1>

{{#md}}{{/md}}

<dl>
	<dt>{{#_}}about/Icons by{{/_}}</dt>
		{{#icons}}
		<dd><a href="{{url}}">{{author}}</a></dd>
		{{/icons}}

	{{#credits}}
	<dt>{{key | _.about}}</dt>
		{{#value}}
		<dd><a href="{{value}}">{{key}}</a></dd>
		{{/value}}
	{{/credits}}

</dl>


{{/ content}}

{{/ layout }}
