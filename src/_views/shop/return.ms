{{% BLOCKS }}
{{< layout }}
{{$ title }}{{#_}}title/Thank you!{{/_}}{{/ title }}
{{$ content}}



<h1>{{#_}}title/Thank you!{{/_}}
	{{>webshop-cart-button}}
</h1>

{{#md}}return{{/md}}


<pre>{{data | debug}}</pre>



{{/ content}}
{{/ layout }}
