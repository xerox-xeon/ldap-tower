<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/8/30
 * Time: 18:33
 */
return [
    'driver' => env('MAIL_DRIVER', 'smtp'),
	'host' => env('MAIL_HOST'),
	'port' => env('MAIL_PORT', 587),
	'username' => env('MAIL_USERNAME'),
	'password' => env('MAIL_PASSWORD'),
	'encryption' => env('MAIL_ENCRYPTION', 'tls'),
    'stream' => [
        'ssl' => [
            'allow_self_signed' => true,
            'verify_peer' => false,
            'verify_peer_name' => false,
        ],
    ]
];