<?php

// Include autoloader and stuff
require 'vendor/autoload.php';


// Set error handler
error_reporting(E_ALL);
$eh = new Error\Handler();
set_exception_handler($eh);
set_error_handler([$eh, 'error']);


// Remove any default headers, like X-Powered-By
header_remove();


// Enable gzip/deflate
//ini_set('zlib.output_compression', 'On');


// Handle request
$time = microtime(true);

$site = new Website(require 'routes.php', PATH);
$site->serve();

$time = microtime(true) - $time;
error_log(number_format($time, 3)."s\t".PATH);
