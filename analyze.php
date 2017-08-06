<?php

require 'vendor/autoload.php';
if(ENV !== 'dev')
	throw new Error\Forbidden(['dev']);
die('off');

$it = new RecursiveDirectoryIterator('data/music', RecursiveDirectoryIterator::SKIP_DOTS);
$it = new RecursiveExtensionFilterIterator($it, '.mp3');
$it = new RecursiveIteratorIterator($it);
$it = new RegexIterator($it, '/\\d+\\./');


header('content-type: text/plain; charset=utf-8');
foreach($it as $file)
{
	$i = ID3::instance()->analyze($file);

	echo "\r\n$file\r\n";
	$ini = substr($file, 0, -3).'ini';
	echo "$ini\r\n";

	$s = sprintf("%s = %s\r\n%s = %s\r\n",
		'duration[number]',
		$i['playtime_seconds'],
		'duration[string]',
		$i['playtime_string']);

	echo $s;
}
