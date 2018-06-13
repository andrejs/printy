<?php

return [
    'geocoder' => [
        'url' => 'http://ip-api.com/json',
        'cache_ttl' => 60, // minutes
        // useful for testing inside of VM
        'emulate_client_ip' => '37.120.31.238',
    ],
    'rate_limiter' => [
        'limit' => 1,  // requests
        'period' => 1, // minutes
    ],
];
