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
        $auth = new \Delight\Auth\Auth($this->container->get('db'));

        $data = $request->getParsedBody();

        try {
            $userId = $auth->register($data['email'], $data['password'], $data['username']);

        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            $this->container->get('flash')->addMessage('reg_error', 'Invalid email address');
            return $response->withRedirect('/registration');
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            $this->container->get('flash')->addMessage('reg_error', 'Invalid password');
            return $response->withRedirect('/registration');
        }
        catch (\Delight\Auth\UserAlreadyExistsException $e) {
            $this->container->get('flash')->addMessage('reg_error', 'User already exists');
            return $response->withRedirect('/registration');
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            $this->container->get('flash')->addMessage('reg_error', 'Too many requests');
            return $response->withRedirect('/registration');
        }
    }
}