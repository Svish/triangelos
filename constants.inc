<?php

// Base paths
define('DOCROOT', realpath(__DIR__).DIRECTORY_SEPARATOR);
define('WEBBASE', $_SERVER['BASE']);
define('WEBROOT', 'http://'.$_SERVER['HTTP_HOST'].WEBBASE);

// Environment
define('ENV', $_SERVER['ENV']);
define('CONFIG', DOCROOT.'config'.DIRECTORY_SEPARATOR);

// Language, Encoding and Locales
mb_internal_encoding("UTF-8");
date_default_timezone_set('Europe/Oslo');
I18N::init(Util::get($_COOKIE, 'host', $_SERVER['HTTP_HOST']));
