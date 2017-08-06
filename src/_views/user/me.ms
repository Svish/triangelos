{{% ACCESS login }}
{{% BLOCKS }}
{{< layout }}
{{$ title }}{{#_}}title/Me{{/_}}{{/ title }}

{{$ content}}



<h1>{{#_}}title/Me{{/_}}</h1>

<div class="flex">

	<section>
		<form action="{{PATH}}" method="post">
			
			<p>
				<input {{#errors.first}}class="error"{{/errors.first}} type="text" name="first" value="{{me.first}}" placeholder="Ditt navn" autocomplete="first" required>
				{{#errors.first}}<span class="field error">{{.}}</span>{{/errors.first}}
			</p>

			<p>
				<input {{#errors.last}}class="error"{{/errors.last}} type="text" name="last" value="{{me.last}}" placeholder="Ditt navn" autocomplete="last" required>
				{{#errors.last}}<span class="field error">{{.}}</span>{{/errors.last}}
			</p>

			<p>
				<input {{#errors.email}}class="error"{{/errors.email}} type="email" name="email" value="{{me.email}}" placeholder="Din epost" autocomplete="email" required>
			{{#errors.email}}<span class="field error">{{.}}</span>{{/errors.email}}
			</p>

			<p>
				<input {{#errors.phone}}class="error"{{/errors.phone}} type="tel" name="phone" value="{{me.phone}}" placeholder="Din epost" autocomplete="phone" required>
			{{#errors.phone}}<span class="field error">{{.}}</span>{{/errors.phone}}
			</p>
			
			<p>
				<input {{#errors.password}}class="error"{{/errors.password}} type="text" name="password" placeholder="Passord, om du vil bytte" value="{{me.password}}" autocomplete="off" optional>
				{{#errors.password}}<span class="field error">{{.}}</span>{{/errors.password}}
			</p>

			<p><button class="icon" type="submit">{{#svg}}save{{/svg}}</button>
		</form>
	</section>

	<section class="no-select frames">
		{{#me}}
		{{> user\badge}}
		{{/me}}
	</section>
	
</div>


{{/ content}}
{{/ layout }}
