<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Session Timeout Configuration
    |--------------------------------------------------------------------------
    |
    | Controls the idle session timeout mechanism.
    | - lifetime: total session lifetime in minutes (must match config/session.php)
    | - warning_time: how many minutes before expiry to show the warning modal
    | - grace_period: seconds the user has to click "Continue" after the warning
    |
    */

    'lifetime' => (int) env('SESSION_LIFETIME', 15),

    'warning_time' => (int) env('SESSION_TIMEOUT_WARNING', 10),

    'grace_period' => (int) env('SESSION_TIMEOUT_GRACE', 120),

    'heartbeat_url' => '/session/heartbeat',

    'logout_url' => '/logout',

    'login_url' => '/login',
];
