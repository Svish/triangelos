{{% BLOCKS }}
<!DOCTYPE html>
<html lang="{{LANG}}">
	<head>
		<title>{{$title}}{{/title}} - Triangelos</title>

		<base href="{{#url}}/{{/url}}" />
		<link rel="canonical" href="{{#url}}/{{PATH}}{{/url}}">

		{{#_.options}}
		<link rel="alternate" hreflang="{{lang}}" href="//{{host}}/{{PATH}}">
		{{/_.options}}

		{{>favicons}}

		<meta name="viewport" content="width=device-width, initial-scale=1">
		{{#_css}}
		<link rel="stylesheet" type="text/css" href="{{.}}">
		{{/_css}}

		{{#_js.first}}
		<script type="text/javascript" src="{{.}}"></script>
		{{/_js.first}}
		{{#_js.defer}}
		<script type="text/javascript" src="{{.}}" defer></script>
		{{/_js.defer}}

		<script>
			var Site = {
					Lang: '{{LANG}}',
					Url: {
						Base: '{{url}}',
						Current: '{{PATH}}',
						Host: '{{HOST}}'
					},
					TestHosts: {{_test_hosts}}
				};
		</script>

	</head>
	<body class="{{_pc}}">

		{{> header}}

		<div id="content">
			{{$content}}{{/content}}
		</div>

		{{> footer}}
	</body>
</html>
