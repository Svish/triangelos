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

		Music.player = $('#jp_player');
		Music.container = $('#jp_container');
		Music.current = null;

		// Create jPlayer
		Music.player.jPlayer({
			cssSelectorAncestor: '#jp_container',
			supplied: 'mp3',
			wmode: 'window',
			solution: 'html',
			ended: Music.nextTrack,
			pause: Music.onPause,
			playing: Music.onPlaying,
			loadstart: Music.onLoadStart,
		});
	},


	onTrackClick: function()
	{
		if($(this).data('id') == Music.current)
			Music.stopTrack();
		else
			Music.playTrack(this);
		return false;
	},

	onPause: function()
	{
		Music.hidePlayer();
	},
	onPlaying: function()
	{
		Music.showPlayer();
	},
	onLoadStart: function()
	{
		Music.showPlayer();
	},


	nextTrack: function()
	{
		Music.playTrack(Music.current + 1);
	},

	prevTrack: function()
	{
		Music.playTrack(Music.current - 1);
	},


	playTrack: function(id)
	{
		var track = Number.isInteger(id)
			? Music.tracks.get(id % Music.tracks.length)
			: id;

		Music.current = $(track).data('id');

		Music.player.jPlayer('setMedia', { mp3: track.href });
		Music.player.jPlayer('play');
	},

	stopTrack: function()
	{
		Music.current = null;
		Music.player.jPlayer('stop');
	},

	showPlayer: function()
	{
		Music.container
			.insertAfter(Music.tracks[Music.current])
			.slideDown(250);
	},
	hidePlayer: function()
	{
		Music.container
			.slideUp(250);
	},

};
$(Music.init);
