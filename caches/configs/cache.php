<?php

return array (
	'file1' => array (
		'type' => 'file',
		'debug' => true,
		'pconnect' => 0,
		'autoconnect' => 0
		),
    'template' => array (
        'hostname' => '',
        'port' => 11211,
        'timeout' => 0,
        'type' => 'memcache',
        'debug' => true,
        'pconnect' => 0,
        'autoconnect' => 0,
    ),
	'redis' => array (
		'hostname' => '127.0.0.1',
		'port' => 6379,
		'timeout' => 0,
		'type' => 'redis',
		'debug' => true,
		'pconnect' => 0,
		'autoconnect' => 0,
		'requirepass' => '',
		'db' => 1,
	)
);

?>
