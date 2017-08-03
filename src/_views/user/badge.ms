<div class="loading">
	<img src="i/450x120/member/{{id}}" alt="{{first | ucwords}}">
	<div class="name">{{first | ucwords }}</div>
	<div class="roles">
		{{#roles}}
		<span>{{{. | ucfirst | _ }}}</span>
		{{/roles}}
	</div>
</div>
