<?php

return [
    'temporary_file_upload' => [
        'disk' => env('LIVEWIRE_TEMP_DISK', 'public'),
        'directory' => 'tmp',
    ],

    'echo' => [
        'broadcaster' => 'pusher',
        'host' => env('PUSHER_HOST', '127.0.0.1'),
        'port' => env('PUSHER_PORT', 6001),
        'scheme' => env('PUSHER_SCHEME', 'https'),
        'key' => env('PUSHER_APP_KEY'),
        'secret' => env('PUSHER_APP_SECRET'),
        'app_id' => env('PUSHER_APP_ID'),
        'options' => [
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'useTLS' => true,
        ],
    ],
];
