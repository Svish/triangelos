{{% BLOCKS }}
{{< layout }}
{{$ title }}{{#_}}title/Calendar{{/_}}{{/ title }}

{{$ content}}


<h1>{{#_}}title/Calendar{{/_}}</h1>

<pre>// TODO</pre>

{{#calendar.calendar}}

	<h2>{{month|df.month-name}}</h2>

	<table class="calendar" width="100%">
		<col>
		<col>
		<col>
		<col>
		<col>
		<col>
		<col>
		<thead>
			<tr>
				<th>{{#_}}Sunday{{/_}}</th>
				<th>{{#_}}Monday{{/_}}</th>
				<th>{{#_}}Tuesday{{/_}}</th>
				<th>{{#_}}Wednesday{{/_}}</th>
				<th>{{#_}}Thursday{{/_}}</th>
				<th>{{#_}}Friday{{/_}}</th>
				<th>{{#_}}Saturday{{/_}}</th>
			</tr>
		</thead>
		<tbody class="checkered">
		{{#weeks}}
		<tr data-week="{{week}}" class="{{#past}}past{{/past}}">
			{{#days}}
			{{^day}}
			<td class="empty"></td>
			{{/day}}
			{{#day}}
			<td id="{{day | df.date-iso}}" 
				data-day="{{day | df.day}}"
				data-week="{{day | df.week}}"
				data-date="{{day | df.date-iso}}"
				data-name="{{day | df.date-day}}">{{#events}}

				<div class="event has-details {{status}} {{transp}} {{continued}} {{private}}" data-details="{{id}}">
					{{^all_day}}<time datetime="{{start|df.w3c}}">{{start | df.time | timeTrim}}</time>{{/all_day}}
					<div class="summary">{{summary | _}}</div>
					<div class="location">{{location | firstLine}}</div>
				</div>

				{{^continued}}
				<div class="details" data-details="{{id}}">
					<article>
						<h1>{{summary|_}}{{>close-link}}</h1>
						<p class="subtitle">
							{{#df.simplify}}
							<time datetime="{{start|df.w3c}}">{{start|df.date}}{{^all_day}}, {{start|df.time}}{{/all_day}}</time>
							 – 
							<time datetime="{{end|df.w3c}}">{{end|df.date}}{{^all_day}}, {{end|df.time}}{{/all_day}}</time>
							{{/df.simplify}}
						</p>

						{{#location}}
							<address>{{{location}}}</address>
						{{/location}}
						
						{{{description}}}
					</article>
				</div>
				{{/continued}}

				{{/events}}</td>
			{{/day}}
			{{/days}}
		</tr>
		{{/weeks}}
	</table>


{{/calendar.calendar}}

<p>
	<a data-name="iCal" href="calendar.ics">{{#_}}Subscribe to the calendar{{/_}}</a>
</p>



<script>
$(function()
{
	// Mark current day and week
	var today = new Date().toISOString().split('T')[0];
	$('[data-date="'+today+'"]', '.calendar')
		.addClass('current')
		.closest('tr')
		.addClass('current');
});
</script>



{{/ content}}

{{/ layout }}
