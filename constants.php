<?php

// Base paths
define('DOCROOT', realpath(__DIR__).DIRECTORY_SEPARATOR);
define('WEBBASE', $_SERVER['BASE']);
define('WEBROOT', 'http://'.$_SERVER['HTTP_HOST'].WEBBASE);

// Environment
define('ENV', $_SERVER['ENV']);
@include DOCROOT.'constants.'.ENV.'.php';

// Configuration
define('CONFIG', DOCROOT.'config'.DIRECTORY_SEPARATOR);

// Language, Encoding and Locales
mb_internal_encoding("UTF-8");
date_default_timezone_set('Europe/Oslo');
require CONFIG.Util::get($_COOKIE, 'host', $_SERVER['HTTP_HOST']).'.inc';

// Directories
define('CACHE', DOCROOT.'.cache'.DIRECTORY_SEPARATOR.LANG.DIRECTORY_SEPARATOR);
define('CONTENT', DOCROOT.'__'.DIRECTORY_SEPARATOR.LANG.DIRECTORY_SEPARATOR);
define('STRINGS', CONTENT.LANG.'.inc');
