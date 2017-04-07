<?php
// Routes

$app->get('/', function ($request, $response, $args) use ($logger){
    // Sample log message
    $logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});


// API group
$app->group('/api', function () use ($app) {

    // Version group: Init Version
    $app->group('/v1', function () use ($app) {

        $app->group('/auth', function () use ($app) {
            $app->post('/register', 'App\Controllers\AuthController:register');//
            $app->post('/login', 'App\Controllers\AuthController:login');//
        });

         $app->group('/transaction', function () use ($app) {
            $app->post('/create', 'App\Controllers\AuthController:createTransaction');
            $app->get('/all', 'App\Controllers\TransactionController:getAll');
        });
         
        $app->get('/users', 'App\Controllers\UserController:getAllUsers');//

    });

});
