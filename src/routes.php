<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes
$app->get('/', '\App\Controllers\PageController:index')->setName('home.page');

$app->get('/profile', '\App\Controllers\ProfileController:index')->setName('profile.index');

$app->get('/login', '\App\Controllers\AuthController:login')->setName('login.page');

$app->post('/login', '\App\Controllers\AuthController:authenticate');

/*$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->view->render($response, 'index.phtml', $args);
});*/
