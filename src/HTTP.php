<?php


/**
 * Utility class for HTTP stuff
 */
class HTTP
{
	/**
	 * Construct proper status header for given HTTP status code.
	 */
	public static function status($code)
	{
		return array_key_exists($code, self::$codes)
			? self::$codes[$code]
			: self::$codes[500];
	}



	/**
	 * Set HTTP response status.
	 */
	public static function set_status($code)
	{
		http_response_code($code);
	}



	/**
	 * Construct proper status header for given HTTP status code.
	 */
	public static function exit_status($code, $message = null)
	{
		$m = "$code ".self::$codes[$code];
		if($message) $m .= ": $message";
		
		self::set_status($code);
		header('Content-Type: text/plain; charset=utf-8');
		exit($m);
	}
	


	/**
	 * Redirect to given target.
	 *
	 * @param code HTTP code to use
	 * @param target URL to redirect to
	 * @param prepend If target should be prepended with WEBROOT
	 */
	public static function redirect($target = NULL, $code = 302, $prepend = TRUE)
	{
		if($prepend)
			$target = WEBROOT.$target;

		header('Location: '.$target, true, $code);
		exit;
	}



	/**
	 * Array of HTTP codes and messages.
	 * @see http://www.iana.org/assignments/http-status-codes/http-status-codes.xhtml
	 */
	public static $codes = [
		// 1xx: Informational - Request received, continuing process
		100 => "Continue",
		101 => "Switching Protocols",
		102 => "Processing",

		// 2xx: Success - The action was successfully received, understood, and accepted
		200 => "OK",
		201 => "Created",
		202 => "Accepted",
		203 => "Non-Authoritative Information",
		204 => "No Content",
		205 => "Reset Content",
		206 => "Partial Content",
		207 => "Multi-Status",
		208 => "Already Reported",

		226 => "IM Used",

		// 3xx: Redirection - Further action must be taken in order to complete the request
		300 => "Multiple Choices",
		301 => "Moved Permanently",
		302 => "Found",
		303 => "See Other",
		304 => "Not Modified",
		305 => "Use Proxy",
		306 => "(Unused)",
		307 => "Temporary Redirect",
		308 => "Permanent Redirect",

		// 4xx: Client Error - The request contains bad syntax or cannot be fulfilled
		400 => "Bad Request",
		401 => "Unauthorized",
		402 => "Payment Required",
		403 => "Forbidden",
		404 => "Not Found",
		405 => "Method Not Allowed",
		406 => "Not Acceptable",
		407 => "Proxy Authentication Required",
		408 => "Request Timeout",
		409 => "Conflict",
		410 => "Gone",
		411 => "Length Required",
		412 => "Precondition Failed",
		413 => "Payload Too Large",
		414 => "URI Too Long",
		415 => "Unsupported Media Type",
		416 => "Range Not Satisfiable",
		417 => "Expectation Failed",

		421 => "Misdirected Request",
		422 => "Unprocessable Entity",
		423 => "Locked",
		424 => "Failed Dependency",

		426 => "Upgrade Required",

		428 => "Precondition Required",
		429 => "Too Many Requests",

		431 => "Request Header Fields Too Large",

		451 => "Unavailable for Legal Reasons",

		// 5xx: Server Error - The server failed to fulfill an apparently valid request
		500 => "Internal Server Error",
		501 => "Not Implemented",
		502 => "Bad Gateway",
		503 => "Service Unavailable",
		504 => "Gateway Timeout",
		505 => "HTTP Version Not Supported",
		506 => "Variant Also Negotiates",
		507 => "Insufficient Storage",
		508 => "Loop Detected",

		510 => "Not Extended",
		511 => "Network Authentication Required",


	];

}
