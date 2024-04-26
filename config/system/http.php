<?php

return [

    /*
     |--------------------------------------------------------------------------
     | Request
     |--------------------------------------------------------------------------
     |
     | HTTP Request options.
     |
     */
    'request'  => [
      'headers' => [
        'Accept' => 'application/json'
      ]
    ],

    /*
     |--------------------------------------------------------------------------
     | Response
     |--------------------------------------------------------------------------
     |
     | HTTP Response options.
     |
     */
    'response' => [
      'headers' => [
        'X-Frame-Options'         => 'deny',
        'X-XSS-Protection'        => '1; mode=block',
        'X-Content-Type-Options'  => 'nosniff',
        'Content-Security-Policy' => 'default-src \'none\''
      ]
    ]

];
