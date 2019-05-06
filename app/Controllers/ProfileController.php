<?php

namespace App\Controllers;


class ProfileController extends AbstractController
{
    public function index($request, $response)
    {
        return $this->view->render($response, 'profile/index.phtml', ['name' => 'Aleksey']);
    }
}