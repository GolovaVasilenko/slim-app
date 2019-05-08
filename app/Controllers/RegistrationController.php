<?php

namespace App\Controllers;


class RegistrationController extends AbstractController
{
    public function index($request, $response)
    {
        $messages = $this->container->get('flash')->getMessages();

        return $this->view->render($response, 'auth/register.phtml', $messages);
    }

    public function registration($request, $response)
    {

    }
}