<?php

return [

    'name' => env('APP_NAME', 'Penguin'),
    'logo' => env('APP_LOGO', '/branding/penguin-logo.svg'),
    // Penguin: dark-theme logo. Defaults to the Penguin dark cut only while
    // APP_LOGO is unset, so a custom logo isn't paired with ours.
    'logo_dark' => env('APP_LOGO_DARK', env('APP_LOGO') ? null : '/branding/penguin-logo-dark.svg'),
    'favicon' => env('APP_FAVICON', '/branding/penguin-favicon.svg'),

    'version' => 'canary',

    'timezone' => 'UTC',

    'installed' => env('APP_INSTALLED', true),

    'exceptions' => [
        'report_all' => env('APP_REPORT_ALL_EXCEPTIONS', false),
    ],

    'fallback_locale' => 'en',

];
