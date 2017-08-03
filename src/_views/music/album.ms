{{% BLOCKS }}
{{< layout }}
{{$ title }}{{album.title}} - {{#_}}title/Music{{/_}}{{/ title }}
{{$ content}}


{{#album}}

	<h1><a href="music/album/{{id}}">{{title}}</a>
		<span>{{#_}}title/Album{{/_}}</span>
	</h1>

	<section class="meta center frames no-select">
		<p>
			<b>{{#_}}Released{{/_}}</b>
			<br>
			{{released | f.date-long}}
		</p>
		<p>
			<b>{{#_}}Spor{{/_}}</b>
			<br>
			{{trackCount}}
		</p>
		<p>
			<b>{{#_}}Total time{{/_}}</b>
			<br>
			{{totalTime | f.duration}}
		</p>
		<p>
			{{> shop/webshop-cart-button}}
		</p>
	</section>

	<section>{{{html}}}</section>

	<section>
		<h2>{{#_}}title/The songs{{/_}}</h2>
		{{> music/tracks}}
	</section>

	<section class="no-select">
		<h2>{{#_}}title/The choir{{/_}}</h2>
		<div class="flex">
			{{#choir}}
			<dl>
				<dt>{{role | ucfirst | _}}</dt>
				{{#members}}
				<dd>{{.}}</dd>
				{{/members}}
			</dl>
			{{/choir}}
		</div>
	</section>

	<section class="no-select">
		<h2>{{#_}}title/The cover{{/_}}</h2>
		<p class="covers">
			
			<img alt="{{#_}}Album cover{{/_}}"
				src="i/400x500/album/{{id}}/cover"
				class="frame">

			<img alt="{{#_}}Album inlay{{/_}}"
				src="i/400x500/album/{{id}}/inlay"
				class="frame">
		</p>
	</section>
{{/album}}


{{! TODO: >jplayer}}


{{/ content}}
{{/ layout }}
