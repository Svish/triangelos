{{% BLOCKS }}
{{< layout }}
{{$ title }}{{#_}}title/Members only{{/_}}{{/ title }}

{{$ content}}


{{_s.login}}


<div class="menu no-select frames">
	
	<a href="user/me">
		{{#svg}}person{{/svg}}<br>
		{{#_}}title/Me{{/_}}
	</a>
	
	{{#_s.admin}}
	<a href="user/index">
		{{#svg}}people{{/svg}}<br>
		{{#_}}title/Everyone{{/_}}
	</a>
	{{/_s.admin}}

	<a href="user/practice">
		{{#svg}}score{{/svg}}<br>
		{{#_}}title/Practice{{/_}}
	</a>
	{{#_s.communicator}}
	<br>
	<a href="user/messages">
		{{#svg}}send{{/svg}}<br>
		{{#_}}title/Send message{{/_}}
	</a>
	{{/_s.communicator}}
	<br>
	<a href="user/logout">
		{{#svg}}logout{{/svg}}<br>
		{{#_}}title/Logout{{/_}}
	</a>
</div>



{{/ content}}
{{/ layout }}
