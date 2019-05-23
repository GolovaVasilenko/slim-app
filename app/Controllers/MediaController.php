<?php

namespace App\Controllers;


use http\Env\Request;
use Slim\Http\Response;

class MediaController extends AdminController
{
    public function index(Request $request, Response $response)
    {
        return $this->view->render('admin/media/index.twig');
    }
}