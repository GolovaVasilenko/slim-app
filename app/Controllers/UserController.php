<?php

namespace App\Controllers;

use App\Services\UserServiceManager;

class UserController extends AdminController
{
    public function index($request, $response)
    {
        $messages = $this->container->get('flash')->getMessages();

        $sm = new UserServiceManager($this->container);

        $users = $sm->all();

        return $this->view->render($response, 'admin/users/index.twig', ['users' => $users, 'messages' => $messages]);
    }

    public function add($request, $response)
    {
        return $this->view->render($response, 'admin/users/add.twig');
    }

    public function store($request, $response)
    {
        $data = $request->getParsedBody();
        $sm = new UserServiceManager($this->container);
        $sm->insert($data);
        $this->container->get('flash')->addMessage('success', 'User is successful added');
        return $response->withRedirect('/admin/users');
    }

    public function edit($request, $response)
    {
        $messages = $this->container->get('flash')->getMessages();

        $id = $request->getAttribute("id");
        $sm = new UserServiceManager($this->container);
        $user = $sm->find($id);
        return $this->view->render($response, 'admin/users/edit.twig', ['user' => $user, 'messages' => $messages]);
    }

    public function update($request, $response)
    {
        $data = $request->getParsedBody();
        $sm = new UserServiceManager($this->container);
        $sm->update($data);
        $this->container->get('flash')->addMessage('success', 'User is successful update');
        return $response->withRedirect('/admin/user/edit/' . (int) $data['id']);
    }

    public function delete($request, $response)
    {
        $id = $request->getAttribute("id");
        $sm = new UserServiceManager($this->container);
        $sm->remove($id);
        return $response->withRedirect('/admin/users');
    }
}