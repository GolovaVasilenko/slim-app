<?php

namespace App\Controllers;

use App\Controllers\AuthController;

class ProfileController extends AbstractController
{
    public function index($request, $response)
    {
        return $this->view->render($response, 'profile/index.phtml', ['name' => 'Aleksey']);
    }
}