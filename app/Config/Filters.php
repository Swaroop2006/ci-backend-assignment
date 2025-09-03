<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use App\Filters\JWTAuthFilter;
use App\Filters\Cors;

class Filters extends BaseConfig
{
    public array $aliases = [
        'csrf'   => \CodeIgniter\Filters\CSRF::class,
        'toolbar'=> \CodeIgniter\Filters\DebugToolbar::class,
        'honeypot'=> \CodeIgniter\Filters\Honeypot::class,
        'jwt'    => JWTAuthFilter::class,
        'cors'   => Cors::class,
    ];

    public array $globals = [
        'before' => ['cors'],
        'after'  => [],
    ];

    public array $methods = [];
    public array $filters = [
        // protect selected routes:
        'jwt' => [
            'before' => [
                'api/auth_users',
                'api/teachers',
            ]
        ],
    ];
}
