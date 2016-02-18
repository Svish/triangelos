<?php

/**
 * Handles compression and serving of javascript files.
 *
 * @see https://developers.google.com/closure/compiler/docs/api-tutorial1
 */
class Controller_Javascript extends CachedController
{
	public function __construct()
	{
		$this->config = self::config();
	}

	public function before(array &$info)
	{
		// Check if known path
		if( ! array_key_exists($info['path'], $this->config->path))
			HTTP::exit_status(404, $info['path']);

		$this->files = $this->config->path[$info['path']];

		parent::before($info);
	}



	protected function cache_valid($cached_time)
	{
		$newest = array_reduce(array_map('filemtime', $this->files), 'max');
		return parent::cache_valid($cached_time)
		   and $cached_time >= $newest;
	}
	


	public function get()
	{
		header('Content-Type: text/javascript; charset=utf-8');
		
		// Gather contents of all input files into one string
		$js = array_map('file_get_contents', $this->files);
		$js = implode(PHP_EOL.PHP_EOL, $js);

		if(ENV == 'dev')
		{
			echo $js;
			return;
		}

		// Setup curl request
		$c = curl_init();
		curl_setopt_array($c, array
		(
			CURLOPT_URL => 'https://closure-compiler.appspot.com/compile',
			CURLOPT_POST => TRUE,
			CURLOPT_POSTFIELDS => http_build_query([
				'language' => 'ECMASCRIPT5',
				'output_info' => 'compiled_code',
				'output_format' => 'text',
				'compilation_level' => 'SIMPLE_OPTIMIZATIONS',
				'js_code' => $js,
			]),
		));

		// Execute and output
		if(curl_exec($c) === FALSE)
			http_response_code(500) and exit("// ERROR: ".curl_error($c));

		// Response is empty if compression fails; default to source
		if(curl_getinfo($c, CURLINFO_CONTENT_LENGTH_DOWNLOAD ) <= 1)
			echo $js;

		curl_close($c);
	}

	

	public static function config()
	{
		return include CONFIG.'javascript.inc';
	}
}