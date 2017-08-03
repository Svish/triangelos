<nav id="menu">

	<a class="no-grow" href="." class="{{#_icp}}index{{/_icp}}">
		{{#svg}}home{{/svg}}
	</a>

	{{^_user}}
	<a class="no-grow {{#_icp}}user{{/_icp}}" href="user/login" title="{{#_}}title/Login{{/_}}">
		{{#svg}}key{{/svg}}
	</a>
	{{/_user}}

	{{#_user}}
	<a class="no-grow logged-in {{#_icp}}user{{/_icp}}" href="user/area" title="{{email}}">
		{{#svg}}key{{/svg}}
	</a>
	{{/_user}}

	<a href="shop" class="{{#_icp}}shop{{/_icp}}">
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
