<?php


namespace App\Controllers;

use Psr\Container\ContainerInterface;

abstract class AbstractController
{
    protected $container;

    protected $view;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->view = $container->get('view');
        $this->view->setLayout("main.phtml");
    }
}