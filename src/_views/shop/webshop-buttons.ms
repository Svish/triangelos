{{#webshop_items}}
<a class="webshop button" href="{{url}}" title="{{#_}}Add to cart{{/_}}: {{item_name}}">
	{{#svg}}{{type}};preserveAspectRatio="none"{{/svg}}
	<span class="text">
		{{#_}}Add to cart{{/_}}
		<br>
		{{amount}} {{currency_code}}
	</span>
</a>
{{/webshop_items}}
