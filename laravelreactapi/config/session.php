<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Session Driver
    |--------------------------------------------------------------------------
    |
    | This option controls the default session "driver" that will be used on
    | requests. By default, we will use the lightweight native driver but
    | you may specify any of the other wonderful drivers provided here.
    |
    | Supported: "file", "cookie", "database", "apc", "memcached", "redis", "array"
    |
    */

    'driver' => env('SESSION_DRIVER', 'file'),

    /*
    |--------------------------------------------------------------------------
    | Session Lifetime
    |--------------------------------------------------------------------------
    |
    | Here you may specify the number of minutes that you wish the session
    | to be allowed to remain idle before it expires. If you want them to
    | immediately expire on the browser closing, set that option.
    |
    */

    'lifetime' => env('SESSION_LIFETIME', 120),

    /*
    |--------------------------------------------------------------------------
    | Session Cookie Name
    |--------------------------------------------------------------------------
    |
    | Here you may change the name of the cookie used to identify a session
    | instance by your application. The cookie will be encrypted so it is
    | not readable from the client.
    |
    */

    'cookie' => env(
        'SESSION_COOKIE',
        Str::slug(env('APP_NAME', 'laravel'), '_').'_session'
    ),

    /*
    |--------------------------------------------------------------------------
    | Session Cookie Path
    |--------------------------------------------------------------------------
    |
    | The session cookie path determines the path for which the cookie will
    | be regarded as available. Typically, this will be '/', but you
    | may customize this if you desire.
    |
    */

    'path' => '/',

    /*
    |--------------------------------------------------------------------------
    | Session Cookie Domain
    |--------------------------------------------------------------------------
    |
    | Here you may change the domain of the cookie used to identify a session
    | instance. This will determine which domains the cookie is available to
    | in your application. A null value means use the request host.
    |
    */

    'domain' => env('SESSION_DOMAIN', null),

    /*
    |--------------------------------------------------------------------------
    | Session Secure Cookie
    |--------------------------------------------------------------------------
    |
    | When set to true, means only cookies will be sent to the server if the
    | browser is making the request over HTTPS. Set this option to true in
    | production environments.
    |
    */

    'secure' => env('SESSION_SECURE_COOKIE', null),

    /*
    |--------------------------------------------------------------------------
    | HTTP Only Cookies
    |--------------------------------------------------------------------------
    |
    | When set to true, means that cookies will only be accessible by the
    | server script and not JavaScript. This is a good setting for cookies
    | containing sensitive information.
    |
    */

    'http_only' => true,

    /*
    |--------------------------------------------------------------------------
    | Same Site Cookies
    |--------------------------------------------------------------------------
    |
    | This option determines how your cookies behave when the browser is
    | making cross-site requests. You may set this to any of the Lax, Strict,
    | or None values.
    |
    | Supported: "lax", "strict", "none", null
    |
    */

    'same_site' => env('SESSION_SAME_SITE', 'lax'),

];