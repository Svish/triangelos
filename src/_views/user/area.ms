{{% BLOCKS }}
{{< layout }}
{{$ title }}{{#_}}title/Members only{{/_}}{{/ title }}

{{$ content}}

<div class="menu no-select frames">
	
	<a href="tools/user/me">
		{{#svg}}person{{/svg}}<br>
		{{#_}}title/Me{{/_}}
	</a>
	
	{{#role.admin}}
	<a href="user/index">
		{{#svg}}people{{/svg}}<br>
		{{#_}}title/Everyone{{/_}}
	</a>
	{{/role.admin}}

	<a href="user/practice">
		{{#svg}}score{{/svg}}<br>
		{{#_}}title/Practice{{/_}}
	</a>
	{{#role.communicator}}
	<br>
	<a href="user/message">
		{{#svg}}send{{/svg}}<br>
		{{#_}}title/Send message{{/_}}
	</a>
	{{/role.communicator}}
	<br>
	<a href="user/logout">
		{{#svg}}logout{{/svg}}<br>
		{{#_}}title/Logout{{/_}}
	</a>
</div>



{{/ content}}
{{/ layout }}
