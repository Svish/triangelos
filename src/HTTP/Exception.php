<?php

class HTTP_Exception extends Exception
{
	protected $httpStatus;
	protected $httpTitle;

	public function __construct($message, $httpStatus = 500, Exception $cause = null, $code = E_USER_ERROR)
	{
		parent::__construct($message, $code, $cause);
		$this->httpStatus = $httpStatus;
		$this->httpTitle = Http::status($httpStatus);
	}

	public function getHttpStatus()
	{
		return $this->httpStatus;
	}
	public function getHttpTitle()
	{
		return $this->httpTitle;
	}
}