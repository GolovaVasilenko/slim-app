<?php

namespace App\Controllers;

use App\Controllers\AuthController;

class ProfileController extends AbstractController
{
    public function index($request, $response)
    {
        $auth = $this->container->get('auth');

        return $this->view->render($response, 'profile/index.twig', [
            'name'  => $auth->getUsername(),
            'email' => $auth->getEmail(),
            'ip'    => $auth->getIpAddress(),
        ]);
    }
}