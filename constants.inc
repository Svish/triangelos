<?php

// System paths
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', realpath(__DIR__).DS);
define('SRC', ROOT.'src'.DS);


// Web paths
define('SCHEME', empty($_SERVER['HTTPS']) || $_SERVER['HTTPS']=='off' ? 'http' : 'https');
define('WEBBASE', $_SERVER['BASE']);
define('WEBROOT', SCHEME.'://'.$_SERVER['HTTP_HOST'].WEBBASE);

// Current path
$path = $_GET['path_uri'] ?? '';
$path = trim($path, '/');
define('PATH', $path ?: 'index');
unset($_GET['path_uri']);

// Environment
define('ENV', $_SERVER['ENV']);


// Language, Encoding and Locales
mb_internal_encoding("UTF-8");
date_default_timezone_set('Europe/Oslo');
I18N::init($_COOKIE['host'] ?? $_SERVER['HTTP_HOST']);
