<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes
$app->get('/', '\App\Controllers\PageController:index')->setName('home.page');

$app->get('/about', '\App\Controllers\PageController:show')->setName('about.page');

$app->get('/profile', '\App\Controllers\ProfileController:index')->add($auth)->setName('profile.index');

$app->get('/login', '\App\Controllers\AuthController:login')->add($is_auth)->setName('login.page');

$app->get('/logout', '\App\Controllers\AuthController:logout')->setName('logout');

$app->post('/login', '\App\Controllers\AuthController:authenticate');

$app->get('/registration', '\App\Controllers\RegistrationController:index')->add($is_auth)->setName('register.page');

$app->post('/registration', '\App\Controllers\RegistrationController:registration');

$app->group('/admin', function() use( $admin ) {
    $this->get('', '\App\Controllers\AdminController:index')->setName('admin');

    $this->get('/users', '\App\Controllers\UserController:index')->setName('user.list');

    $this->get('/user/add', '\App\Controllers\UserController:add')->setName('user.add');

    $this->post('/user/store', '\App\Controllers\UserController:store')->setName('user.store');

    $this->post('/user/update', '\App\Controllers\UserController:update')->setName('user.update');

    $this->get('/user/edit/{id:[0-9]+}', '\App\Controllers\UserController:edit')->setName('user.edit');

    $this->get('/user/delete/{id:[0-9]+}', '\App\Controllers\UserController:delete')->setName('user.delete');
})->add($admin) ;
