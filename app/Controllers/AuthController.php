<?php


namespace App\Controllers;


class AuthController extends AbstractController
{
    public function login($request, $response)
    {
        return $this->view->render($response, 'auth/login.phtml');
    }

    public function authenticate($request, $response, $args)
    {
        $auth = new \Delight\Auth\Auth($this->container->get('db'));

        $data = $request->getParsedBody();

        $auth->login($data['email'], $data['password']);
        var_dump($data);
    }
}