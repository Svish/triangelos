{{% BLOCKS }}
{{< layout }}
{{$ title }}{{#_}}title/Calendar{{/_}}{{/ title }}

{{$ content}}


<h1>{{#_}}title/Calendar{{/_}}</h1>

{{#calendar}}

	<h2>{{ month | f.month | _}}</h2>

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
				<th>{{#_}}cal/Sunday{{/_}}</th>
				<th>{{#_}}cal/Monday{{/_}}</th>
				<th>{{#_}}cal/Tuesday{{/_}}</th>
				<th>{{#_}}cal/Wednesday{{/_}}</th>
				<th>{{#_}}cal/Thursday{{/_}}</th>
				<th>{{#_}}cal/Friday{{/_}}</th>
				<th>{{#_}}cal/Saturday{{/_}}</th>
			</tr>
		</thead>
		<tbody class="checkered">
		{{#weeks}}
		<tr data-week="{{week}}" class="{{past}}">
			{{#days}}
			{{^day}}
			<td class="empty"></td>
			{{/day}}
			{{#day}}
			<td id="{{day | f.iso}}" 
				data-day="{{day | f.day}}"
				data-week="{{day | f.week}}"
				data-date="{{day | f.iso}}"
				data-name="{{day | f.date-day}}">{{#events}}
				<a class="event {{status}} {{transp}} {{continued}} {{private}}" href="calendar/event/{{uid}}">
					{{^.day}}<time datetime="{{start|f.w3c}}">{{start | f.time | f.timeTrim}}</time>{{/.day}}
					<div class="summary" title="{{summary | _.cal}}">{{summary | _.cal}}</div>
					<div class="location" title="{{location}}">{{location | fl}}</div>
				</a>

				{{/events}}</td>
			{{/day}}
			{{/days}}
		</tr>
		{{/weeks}}
	</table>


{{/calendar}}

<p>
	<a data-name="iCal" href="calendar.ics">{{#_}}cal/Subscribe to the calendar{{/_}}</a>
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
