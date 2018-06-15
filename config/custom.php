<?php

return [
    'geocoder' => [
        'enabled' => true,
        'url' => 'http://ip-api.com/json',
        'cache_ttl' => 60, // minutes
        'default_country' => 'US',
    ],
    'rate_limiter' => [
        'limit' => 1,  // requests
        'period' => 1, // minutes
    ],
    'quote' => [
       'min_order_price' => 10,
    ],
];
