<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Trusted Proxies
    |--------------------------------------------------------------------------
    |
    | Set trusted proxy IP addresses. Both IPv4 and IPv6 addresses are
    | supported, along with CIDR notation. The "*" character is syntactic
    | sugar within TrustedProxy to trust any proxy that connects
    | directly to your server, a requirement when you cannot know the address
    | of your proxy (e.g. if using ELB or similar).
    |
    */

    'proxies' => env('TRUSTED_PROXIES', '*'),

    /*
    |--------------------------------------------------------------------------
    | Trusted Headers
    |--------------------------------------------------------------------------
    |
    | These are the headers that your reverse proxy uses to send information
    | about the original request to your application. Common values are
    | 'X-Forwarded-For', 'X-Forwarded-Host', 'X-Forwarded-Proto', and
    | 'X-Forwarded-Port'. If your proxy uses different headers, you can
    | specify them here.
    |
    */

    'headers' => [
        'FORWARDED',
        'X-FORWARDED-FOR',
        'X-FORWARDED-HOST',
        'X-FORWARDED-PORT',
        'X-FORWARDED-PROTO',
        'X-FORWARDED-AWS-ELB',
    ],

];
