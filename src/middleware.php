<?php
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
        // ->withHeader('Access-Control-Allow-Origin', 'http://localhost')
        ->withHeader('Access-Control-Allow-Origin', '*')//To allow anyone access
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        ->withHeader('Content-type', 'application/json');
});