
<form action="contact/email" method="post">
	
	<p><input {{#errors.from}}class="error"{{/errors.from}}
		type="email"
		name="from"
		placeholder="{{#_}}form/Your email{{/_}}"
		value="{{_post.from}}"
		required>
	{{#errors.from}}<span class="field error">{{.}}</span>{{/errors.from}}
	
	<p><input {{#errors.subject}}class="error"{{/errors.subject}}
		type="text"
		name="subject"
		placeholder="{{#_}}form/Your subject{{/_}}"
		value="{{_post.subject}}"
		required>
	{{#errors.subject}}<span class="field error">{{.}}</span>{{/errors.subject}}
	
	<p><textarea {{#errors.message}}class="error"{{/errors.message}} 
		name="message"
		placeholder="{{#_}}form/Your message{{/_}}"
		required>{{_post.message}}</textarea>
	{{#errors.message}}<span class="field error">{{.}}</span>{{/errors.message}}
	
	<p><button class="icon" type="submit">{{#svg}}send;style="width:2em"{{/svg}}</button>
</form>
