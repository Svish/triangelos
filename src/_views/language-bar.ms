
<div id="language-bar">
	{{#_.options}}
	<a class="language {{#_icl}}{{lang}}{{/_icl}}"
		href="//{{host}}/{{PATH}}"
		rel="alternate"
		hreflang="{{lang}}"
		lang="{{lang}}"
		title="{{name}}"
		data-host="{{host}}">{{#svg}}flag/{{flag}}{{/svg}}</a>
	{{/_.options}}
</div>
