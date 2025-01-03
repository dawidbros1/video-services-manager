<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

ini_set("session.gc_maxlifetime", '31536000');
ini_set('session.cookie_lifetime', '31536000');
ini_set('session.gc_probability', '1');
ini_set('session.gc_divisor', '1');

session_start();

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
(require_once __DIR__.'/../bootstrap/app.php')
    ->handleRequest(Request::capture());
