<?php

namespace App\Controllers;


class AdminController extends AbstractController
{
    public function index($request, $response)
    {
        $this->view->render($response, 'admin/index.twig');
    }
}