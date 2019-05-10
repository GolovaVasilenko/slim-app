<?php
// DIC configuration

$container = $app->getContainer();

// view renderer
/*$container['view'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Slim\Views\PhpRenderer($settings['template_path']);
};*/
// Register component on container
$container['view'] = function ($container) {
    $settings = $container->get('settings')['renderer'];

    $view = new \Slim\Views\Twig($settings['template_path'], [
        'cache' => /*'tmp/cache'*/false
    ]);

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

    return $view;
};

// Register provider
$container['flash'] = function () {
    return new \Slim\Flash\Messages();
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

//database
$container['db'] = function ($c) {
    $db = $c->get('settings')['db'];
    $pdo = new PDO($db['dsn'] . $db['dbname'], $db['user'], $db['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};

// Auth Container
$container['auth'] = function($c) {
    return new \Delight\Auth\Auth($c->get('db'));
};