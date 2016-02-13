<?php

// Base paths
define('DOCROOT', realpath(__DIR__).DIRECTORY_SEPARATOR);
define('WEBBASE', $_SERVER['BASE']);
define('WEBROOT', 'http://'.$_SERVER['HTTP_HOST'].WEBBASE);

// Environment
define('ENV', $_SERVER['ENV']);
@include DOCROOT.'constants.'.ENV.'.php';


// Language, Encoding and Locales
mb_internal_encoding("UTF-8");
date_default_timezone_set('Europe/Oslo');
switch(Util::get($_COOKIE, 'host', $_SERVER['HTTP_HOST']))
{
	case 'triangelos.no':
		define('LANG', 'no');
		define('LOCALE', 'nb_NO');
		define('LC', setlocale(LC_ALL, 'nb_NO.utf8', 'nb_NO.utf-8', 'nb_NO', 'nor', ''));
		setlocale(LC_NUMERIC, 'C');
		break;

	case 'triangelos.net':
	default:
		define('LANG', 'en');
		define('LOCALE', 'en_US');
		define('LC', setlocale(LC_ALL, 'en_US.utf8', 'en_US.utf-8', 'en_US', 'eng', ''));
		setlocale(LC_NUMERIC, 'C');
		break;
}

// Directories
define('CACHE', DOCROOT.'.cache'.DIRECTORY_SEPARATOR.LANG.DIRECTORY_SEPARATOR);
define('CONFIG', DOCROOT.'config'.DIRECTORY_SEPARATOR);
define('CONTENT', DOCROOT.'__'.DIRECTORY_SEPARATOR.LANG.DIRECTORY_SEPARATOR);
define('STRINGS', CONTENT.LANG.'.inc');
