/**
 * Handles navigation, TOC creation and soft scrolling.
 */
var Music = {

	init: function()
	{
		// Collect tracks
		Music.tracks = $('a', '.tracks')
			.each(function(n) {$(this).data('id', n);})
			.on('click', Music.onTrackClick);

		// Hook up out button
		$('.jp-play-pause', '#jp_container')
			.on('click', Music.onPlayPause);

		// Create jPlayer
		Music.current = null;
		Music.container = $('#jp_container');
		Music.player = $('#jp_player').jPlayer({
			cssSelectorAncestor: '#jp_container',
			supplied: 'mp3',
			wmode: 'window',
			solution: 'html',
			ended: Music.nextTrack,
			playing: Music.onPlaying,
			loadstart: Music.onLoadStart,
		});
	},


	onTrackClick: function(event)
	{
		if($(this).data('id') == Music.current)
			Music.onPlayPause();
		else
			Music.playTrack(this);

		event.stopPropagation();
		return false;
	},

	

	onPlayPause: function(e)
	{
		if(Music.container.hasClass('jp-state-playing'))
			Music.pauseTrack();
		else
			Music.playTrack();
	},

	onPlaying: function()
	{
		NProgress.done();
		Music.showPlayer();
	},

	onLoadStart: function()
	{
		NProgress.start();
	},



	loadTrack: function(id)
	{
		var track = Number.isInteger(id)
			? Music.tracks.get(id % Music.tracks.length)
			: id;
		Music.current = $(track).data('id');
		Music.player.jPlayer('setMedia', 
			{ 
				mp3: track.href,
				title: track.innerHTML,
			});
	},



	showPlayer: function()
	{
		var current = Music.tracks[Music.current];

		if(Music.container.is(':visible') && current == Music.container.prev()[0])
			return;

		Music.container
			.slideUp(250, function()
			{
				Music.container
					.insertAfter(current)
					.slideDown(250);
			});

	},



	playTrack: function(id)
	{
		if(typeof id != 'undefined')
			Music.loadTrack(id);

		Music.player.jPlayer('play');
	},

	pauseTrack: function()
	{
		Music.player.jPlayer('pause');
	},



	nextTrack: function()
	{
		Music.playTrack(Music.current + 1);
	},

	prevTrack: function()
	{
		Music.playTrack(Music.current - 1);
	},



};
$(Music.init);
