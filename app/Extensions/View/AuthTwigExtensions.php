<?php


namespace App\Extensions\View;


use Slim\Views\TwigExtension;

class AuthTwigExtensions extends TwigExtension
{

    protected $auth;

    public function __construct($router, $uri, $auth)
    {
        parent::__construct($router, $uri);

        $this->auth = $auth;
    }

    public function getName()
    {
        return 'AuthTwigExtensions';
    }

    public function getFunctions()
    {
        $functions =  parent::getFunctions();
        $functions[] = new \Twig\TwigFunction('is_auth', array($this, 'isAuth'));
        return $functions;
    }

    public function isAuth()
    {
        return $this->auth->isLoggedIn();
    }
}