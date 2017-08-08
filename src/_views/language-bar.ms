
<div id="language-bar">
	<a class="current" href="about"
		title="{{#_}}title/About the site{{/_}}">{{#svg}}info{{/svg}}</a>
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
