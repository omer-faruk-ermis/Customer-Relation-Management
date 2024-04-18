<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Cache Store
    |--------------------------------------------------------------------------
    |
    | This option controls the default cache connection that gets used while
    | using this caching library. This connection is used when another is
    | not explicitly specified when executing a given caching function.
    |
    */

    'default' => env('CACHE_DRIVER', 'file'),

    /*
    |--------------------------------------------------------------------------
    | Cache Stores
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the cache "stores" for your application as
    | well as their drivers. You may even define multiple stores for the
    | same cache driver to group types of items stored in your caches.
    |
    | Supported drivers: "apc", "array", "database", "file",
    |         "memcached", "redis", "dynamodb", "octane", "null"
    |
    */

    'stores' => [

        'apc' => [
            'driver' => 'apc',
        ],

        'array' => [
            'driver'    => 'array',
            'serialize' => false,
        ],

        'database' => [
            'driver'          => 'database',
            'table'           => 'cache',
            'connection'      => null,
            'lock_connection' => null,
        ],

        'file' => [
            'driver' => 'file',
            'path'   => storage_path('framework/cache/data'),
        ],

        'memcached' => [
            'driver'  => 'memcached',
            'default' => env('CACHE_DRIVER', 'memcached'),

            'stores' => [
                'memcached' => [
                    'driver'        => 'memcached',
                    'persistent_id' => env('MEMCACHED_PERSISTENT_ID'),
                    'sasl'          => [
                        env('MEMCACHED_USERNAME'),
                        env('MEMCACHED_PASSWORD'),
                    ],
                    'servers'       => [
                        [
                            'host'   => env('MEMCACHED_HOST', '10.10.10.153'),
                            'port'   => env('MEMCACHED_PORT', 11211),
                            'weight' => 100,
                        ],
                    ],
                ],
            ],
        ],



        'memcache' => [
            'driver'        => 'memcache',
            'default'       => env('CACHE_DRIVER', 'memcache'),

            'stores'        => [
                'memcache' => [
                    'driver'        => 'memcache',
                    'persistent_id' => env('MEMCACHE_PERSISTENT_ID'),
                    'servers'       => [
                        [
                            'host'   => env('MEMCACHE_HOST', '127.0.0.1'),
                            'port'   => env('MEMCACHE_PORT', 11211),
                            'weight' => 100,
                        ],
                    ],
                ],
            ],
        ],

        'redis' => [
            'driver' => 'redis',
            'client' => env('REDIS_CLIENT', 'predis'),
            'options' => [
                'prefix'  => null,
                'ttl' => 86400,
                'serializer' => 'php'
            ],
            'default' => [
                'host'     => env('REDIS_LOCAL_HOST', '127.0.0.1'),
                'password' => env('REDIS_LOCAL_PASSWORD', null),
                'port'     => env('REDIS_LOCAL_PORT', 6379),
                'database' => env('REDIS_LOCAL_DB', 1),
            ],
            'prod' => [
                'host'     => env('REDIS_PROD_HOST'),
                'password' => env('REDIS_PROD_PASSWORD'),
                'port'     => env('REDIS_PROD_PORT'),
                'database' => env('REDIS_PROD_DB'),
            ],
        ],

        'prod' => [
            'driver'     => 'redis',
            'connection' => 'prod',
            'client'     => env('REDIS_CLIENT', 'predis'),
            'options' => [
                'prefix'  => null,
                'serializer' => 'php',
                'ttl' => 86400
            ],
            'default' => [
                'host'     => env('REDIS_PROD_HOST'),
                'password' => env('REDIS_PROD_PASSWORD'),
                'port'     => env('REDIS_PROD_PORT'),
                'database' => env('REDIS_PROD_DB', 'DB14'),
            ],
        ],

        'dynamodb' => [
            'driver'   => 'dynamodb',
            'key'      => env('AWS_ACCESS_KEY_ID'),
            'secret'   => env('AWS_SECRET_ACCESS_KEY'),
            'region'   => env('AWS_DEFAULT_REGION', 'us-east-1'),
            'table'    => env('DYNAMODB_CACHE_TABLE', 'cache'),
            'endpoint' => env('DYNAMODB_ENDPOINT'),
        ],

        'octane' => [
            'driver' => 'octane',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Key Prefix
    |--------------------------------------------------------------------------
    |
    | When utilizing a RAM based store such as APC or Memcached, there might
    | be other applications utilizing the same cache. So, we'll specify a
    | value to get prefixed to all our keys so we can avoid collisions.
    |
    */

    'prefix' => env('CACHE_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_') . '_cache'),

];
