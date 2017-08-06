<nav id="menu">

	<a href="."
		title="{{#_}}title/Home{{/_}}"
		class="no-grow {{#_icp}}index{{/_icp}}">
		{{#svg}}home{{/svg}}
	</a>

	{{^_user}}
	<a href="user/login"
		title="{{#_}}title/Login{{/_}}"
		class="no-grow {{#_icp}}user{{/_icp}}">
		{{#svg}}key{{/svg}}
	</a>
	{{/_user}}

	{{#_user}}
	<a href="user/area"
		title="{{email}}"
		class="no-grow logged-in {{#_icp}}user{{/_icp}}">
		{{#svg}}key{{/svg}}
	</a>
	{{/_user}}

	<a href="webshop"
		title="{{#_}}title/Webshop{{/_}}"
		class="{{#_icp}}shop{{/_icp}}">
		{{#svg}}cart{{/svg}}
	</a>
		
	<a href="music" class="{{#_icp}}music{{/_icp}}">
		<span>{{#_}}title/Music{{/_}}</span>
	</a>

	<a href="video" class="{{#_icp}}video{{/_icp}}">
		<span>{{#_}}title/Video{{/_}}</span>
	</a>

	<a href="calendar" class="{{#_icp}}calendar{{/_icp}}">
		<span>{{#_}}title/Calendar{{/_}}</span>
	</a>

	<a href="choir" class="{{#_icp}}choir{{/_icp}}">
		<span>{{#_}}title/Choir{{/_}}</span>
	</a>

	<a href="members" class="{{#_icp}}members{{/_icp}}">
		<span>{{#_}}title/Members{{/_}}</span>
	</a>

	<a href="contact" class="{{#_icp}}contact{{/_icp}}">
		<span>{{#_}}title/Contact{{/_}}</span>
	</a>
</nav>
