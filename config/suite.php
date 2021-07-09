<?php

return [
    'api_version' =>  env('SUITE_VERSION','v1'),        
    'base_url' => env('SUITE_BASE_URL'),
    'auth' => [
        'client_id' => env('SUITE_CLIENT_ID'),
        'client_secret' => env('SUITE_CLIENT_SECRET'),
    ],
];
