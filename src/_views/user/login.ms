{{% BLOCKS }}
{{< layout }}
{{$ title }}{{#_}}title/Login{{/_}}{{/ title }}

{{$ content}}



<h1>{{#_}}title/Login{{/_}}</h1>

<form action="{{PATH}}" method="post">

	<input type="hidden" name="url" value="{{_post.url}}">
	
	<p><input required type="email" name="email" placeholder="{{#_}}Your email{{/_}}" value="{{_post.email}}" autocomplete="email" autofocus>
	
	<p><input required type="password" name="password" placeholder="{{#_}}Your password{{/_}}">
	
	<p>
		<button class="icon" type="submit">{{#svg}}login{{/svg}}</button>
		&nbsp;
		<a class="small" href="user/reset">{{#_}}title/Need a password?{{/_}}</a>
	</p>
</form>



{{/ content}}
{{/ layout }}
