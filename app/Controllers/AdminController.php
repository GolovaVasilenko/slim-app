<?php

namespace App\Controllers;


use Psr\Container\ContainerInterface;

class AdminController extends AbstractController
{

    public function index($request, $response)
    {
        $this->view->render($response, 'admin/index.twig');
    }
}