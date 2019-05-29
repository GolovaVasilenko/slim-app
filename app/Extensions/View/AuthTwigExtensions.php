<?php


namespace App\Extensions\View;

use Slim\Views\TwigExtension;

class AuthTwigExtensions extends TwigExtension
{

    protected $auth;

    protected $container;

    public function __construct($router, $uri, $container)
    {
        parent::__construct($router, $uri);

        $this->container = $container;
        $this->auth = $container->get('auth');

    }

    public function getName()
    {
        return 'AuthTwigExtensions';
    }

    public function getFunctions()
    {
        $functions =  parent::getFunctions();
        $functions[] = new \Twig\TwigFunction('is_auth', array($this, 'isAuth'));
        $functions[] = new \Twig\TwigFunction('is_admin', array($this, 'isAdmin'));
        $functions[] = new \Twig\TwigFunction('get_user', array($this, 'getUser'));
        return $functions;
    }

    public function isAuth()
    {
        return $this->auth->isLoggedIn();
    }

    public function isAdmin()
    {
        return $this->auth->hasRole(\Delight\Auth\Role::ADMIN);
    }

    public function getUser()
    {
        $sm = new \App\Services\UserServiceManager($this->container);
        return $sm->find($this->auth->id());

    }
}