<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes
$app->get('/', '\App\Controllers\PageController:index')->setName('home.page');

$app->get('/profile', '\App\Controllers\ProfileController:index')->setName('profile.index');

$app->get('/login', '\App\Controllers\AuthController:login')->setName('login.page');

$app->post('/login', '\App\Controllers\AuthController:authenticate');

$app->get('/registration', '\App\Controllers\RegistrationController:index')->setName('register.page');

$app->post('/registration', '\App\Controllers\RegistrationController:registration');

/*$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->view->render($response, 'index.phtml', $args);
});*/
