<?php

namespace App\Controllers;


class AuthController extends AbstractController
{
    public function login($request, $response)
    {
        $messages = $this->container->get('flash')->getMessages();

        return $this->view->render($response, 'auth/login.twig', $messages);
    }

    public function authenticate($request, $response, $args)
    {
        $auth = $this->container->get('auth');

        $data = $request->getParsedBody();

        if($data['remember'] == 1) {
            $rememberDuration = (int) (60 * 60 * 24 * 20);
        }

        try{
            $auth->login($data['email'], $data['password'], $rememberDuration);
            return $response->withRedirect('/profile');

        }catch (\Delight\Auth\InvalidEmailException $e) {
            $this->container->get('flash')->addMessage('login_error', 'Wrong email address');
            return $response->withRedirect('/login');
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            $this->container->get('flash')->addMessage('login_error', 'Wrong password');
            return $response->withRedirect('/login');
        }
        catch (\Delight\Auth\EmailNotVerifiedException $e) {
            $this->container->get('flash')->addMessage('login_error', 'Email not verified');
            return $response->withRedirect('/login');
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            $this->container->get('flash')->addMessage('login_error', 'Too many requests');
            return $response->withRedirect('/login');
        }

    }

    public function logout($request, $response)
    {
        $auth = $this->container->get('auth');
        if ($auth->isLoggedIn()) {
            $auth->logOut();
            return $response->withRedirect('/');
        }
    }
}