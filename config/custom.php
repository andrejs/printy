<?php

return [
    'geocoder' => [
        'url' => 'http://ip-api.com/json',
        'cache_ttl' => 1,
        // useful for testing inside of VM
        'emulate_client_ip' => '37.120.31.238',
    ],
    'rate_limiter' => [
        'max' => 1,
    ],
];
