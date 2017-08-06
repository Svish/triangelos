{{% BLOCKS }}
{{< layout }}
{{$ title }}{{#_}}title/I need a password{{/_}}{{/ title }}

{{$ content}}



<h1>{{#_}}title/I need a password{{/_}}</h1>

{{#md}}{{/md}}

<form action="{{PATH}}" method="post">
	
	<p><input type="email" name="email" placeholder="{{#_}}Your email{{/_}}" value="{{_post.email}}">
	<ul class="errors">{{#errors.email}}<li>{{.}}</li>{{/errors.email}}</ul>	

	<p>
		<button class="icon" type="submit">{{#svg}}login{{/svg}}</button>
	</p>
</form>



{{/ content}}
{{/ layout }}
