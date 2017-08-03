
<iframe src="https://www.youtube.com/embed/VgC4b9K-gYU?enablejsapi=1"></iframe>

<script>
function onReady()
{
	console.info('Player loaded');
}

window.addEventListener('message', function(e, origin)
{
	var data = JSON.parse(e.data);
	if(data.event == 'onReady')
		onReady();
});

var frame = null;
window.addEventListener('load', function()
{
	frame = document.querySelector('iframe');

	frame.contentWindow.postMessage(JSON.stringify({
		event: 'listening',
		id: 1,
		channel: 'test',
	}), '*');

	frame.contentWindow.postMessage(JSON.stringify({
		event: 'command',
		func: 'addEventListener',
		args: ['onReady'],
		id: 1,
		channel: 'test',
	}), '*');
});
</script>
