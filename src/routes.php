<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes
$app->get('/', '\App\Controllers\PageController:index')->setName('home.page');

$app->get('/about', '\App\Controllers\PageController:show')->setName('about.page');

$app->get('/profile', '\App\Controllers\ProfileController:index')->add($auth)->setName('profile.index');

$app->get('/login', '\App\Controllers\AuthController:login')->add($is_auth)->setName('login.page');

$app->get('/logout', '\App\Controllers\AuthController:login')->setName('logout');

$app->post('/login', '\App\Controllers\AuthController:authenticate');

$app->get('/registration', '\App\Controllers\RegistrationController:index')->add($is_auth)->setName('register.page');

$app->post('/registration', '\App\Controllers\RegistrationController:registration');
