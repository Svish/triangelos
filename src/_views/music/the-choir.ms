<section id="the-choir" class="toc no-select">
	<h2>{{#_}}title/The choir{{/_}}</h2>
	<div class="flex">
		{{#choir}}
		<dl>
			<dt>{{key | ucfirst | _}}</dt>
			{{#value}}
			<dd>{{.}}</dd>
			{{/value}}
		</dl>
		{{/choir}}
	</div>
</section>
