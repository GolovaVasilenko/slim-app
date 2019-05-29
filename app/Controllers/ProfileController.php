<?php

namespace App\Controllers;

use App\Services\UserServiceManager;

class ProfileController extends AbstractController
{
    public function index($request, $response)
    {
        $auth = $this->container->get('auth');

        $sm = new UserServiceManager($this->container);

        $user = $sm->find($auth->id());

        return $this->view->render($response, 'profile/index.twig', [
            'name'  => $user->username,
            'email' => $user->email,
            'avatar' => $user->avatar,
            'ip'    => $auth->getIpAddress(),
        ]);
    }
}