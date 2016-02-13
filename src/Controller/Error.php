<?php

/**
 * Error handler.
 */
class Controller_Error extends Controller_Page
{
	public function __invoke($e = null)
	{
		if( ! $e instanceof HTTP_Exception)
			$e = new HTTP_Exception('Internal Server Error', 500, $e);

		$this->get('error', [
			'status' => $e->getHttpStatus(),
			'title' => $e->getHttpTitle(),
			'message' => $e->getMessage(),
			'debug' => self::collect_xdebug($e),
			]);
	}

	private static function collect_xdebug(Exception $e = null)
	{
		if( ! $e)
			return null;

		$msg = isset($e->xdebug_message) ? $e->xdebug_message : '';

		return $msg . self::collect_xdebug($e->getPrevious());
	}

}
