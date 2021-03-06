
<section id="the-credits" class="no-select">

	<h2>{{#_}}title/The credits{{/_}}</h2>
	<div class="flex p">
		{{#credits}}
		<dl>
			<dt>{{key | ucfirst | _}}</dt>
			{{#value}}
			<dd>{{ . | __}}</dd>
			{{/value}}
		</dl>
		{{/credits}}
	</div>

	<div class="flex p parts">
		{{#parts}}
		<div class="p">
			<h3>{{title}}</h3>
			<dl>
				{{#value}}
				<dt>{{key | ucfirst | _}}</dt>
				{{#value}}
				<dd>{{ . | __}}</dd>
				{{/value}}
				{{/value}}
			</dl>
		</div>
		{{/parts}}
	</div>

</section>

