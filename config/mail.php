<?php

return [

    'default' => env('APP_DEBUG', false) ? 'log' : 'smtp',

    'mailers' => [

        'smtp' => [
            'encryption' => null,
            'auth_mode' => env('MAIL_USERNAME') || env('MAIL_PASSWORD') ? 'login' : null,
            'verify_peer' => false,
            'transport' => 'smtp',
            'scheme' => null,
            'url' => null,
            'host' => env('MAIL_HOST', '127.0.0.1'),
            'port' => env('MAIL_PORT', 25),
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
            'timeout' => null,
            'local_domain' => 'localhost',
        ],

        'ses' => [
            'transport' => 'ses',
        ],

        'postmark' => [
            'transport' => 'postmark',
            // 'message_stream_id' => env('POSTMARK_MESSAGE_STREAM_ID'),
            // 'client' => [
            //     'timeout' => 5,
            // ],
        ],

        'resend' => [
            'transport' => 'resend',
        ],

        'sendmail' => [
            'transport' => 'sendmail',
            'path' => env('MAIL_SENDMAIL_PATH', '/usr/sbin/sendmail -bs -i'),
        ],

        'log' => [
            'transport' => 'log',
            'channel' => env('MAIL_LOG_CHANNEL'),
        ],

        'array' => [
            'transport' => 'array',
        ],

        'failover' => [
            'transport' => 'failover',
            'mailers' => [
                'smtp',
                'log',
            ],
        ],

        'roundrobin' => [
            'transport' => 'roundrobin',
            'mailers' => [
                'ses',
                'postmark',
            ],
        ],

    ],

    'from' => [
        'address' => isset($_SERVER['HTTP_HOST']) ? "me@{$_SERVER['HTTP_HOST']}" : 'me@localhost',
        'name' => 'UOL Brazil',
    ],

];
