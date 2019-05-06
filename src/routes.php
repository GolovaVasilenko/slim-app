<?php

use Slim\Http\Request;
use Slim\Http\Response;

// Routes
$app->get('/', '\App\Controllers\PageController:index')->setName('home.page');

/*$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->view->render($response, 'index.phtml', $args);
});*/
