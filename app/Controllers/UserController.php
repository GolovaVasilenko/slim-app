<?php

namespace App\Controllers;

use App\Services\UserServiceManager;

class UserController extends AdminController
{
    public function index($request, $response)
    {
        $sm = new UserServiceManager($this->container);

        $users = $sm->all();

        return $this->view->render($response, 'admin/users/index.twig', ['users' => $users]);
    }

    public function add($request, $response)
    {
        return $this->view->render($response, 'admin/users/add.twig');
    }

    public function store($request)
    {
        $data = $request->getParsedBody();

    }

    public function edit($request, $response)
    {
        return $this->view->render($response, 'admin/users/edit.twig');
    }

    public function update($request)
    {

    }

    public function delete($request)
    {

    }
}