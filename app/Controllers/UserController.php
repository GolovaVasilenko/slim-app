<?php

namespace App\Controllers;

use App\Helpers\FileUploader;
use App\Services\UserServiceManager;
use Slim\Http\Request;
use Slim\Http\Response;

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
        $messages = $this->container->get('flash')->getMessages();

        return $this->view->render($response, 'admin/users/add.twig', ['messages' => $messages]);
    }

    public function store($request, $response)
    {
        $data = $request->getParsedBody();

        try {
            $userId = $this->container->get('auth')->admin()->createUser($data['email'], $data['password'], $data['username']);

            $this->container->get('flash')->addMessage('success', 'User is successful added');
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
            $this->container->get('flash')->addMessage('errors', 'Invalid email address');
            return $response->withRedirect('/admin/user/add');
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
            $this->container->get('flash')->addMessage('errors', 'Invalid password');
            return $response->withRedirect('/admin/user/add');
        }
        catch (\Delight\Auth\UserAlreadyExistsException $e) {
            $this->container->get('flash')->addMessage('errors', 'User already exists');
            return $response->withRedirect('/admin/user/add');
        }


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

    public function update(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $file = $request->getUploadedFiles()['avatar'];

        if(!empty($file->file)) {
            $dir = $this->container->get('settings')['media']['uploaded'];
            $manager = new FileUploader();
            $fileName = $manager->saveAvatar($file, $dir);
            $data['avatar'] = $manager->getUploadDir() . $fileName;
        }

        $sm = new UserServiceManager($this->container);
        $sm->update($data);
        $this->container->get('flash')->addMessage('success', 'User is successful update');
        return $response->withRedirect('/admin/user/edit/' . (int) $data['id']);
    }

    public function delete($request, $response)
    {
        $id = $request->getAttribute("id");

        $sm = new UserServiceManager($this->container);
        $user = $sm->find($id);

        if(!empty($user->avatar) && $this->removeAvatar($user->avatar)) {
            $sm->remove($id);
            $this->container->get('flash')->addMessage('success', 'User is successful removed');
        }
        else {
            $this->container->get('flash')->addMessage('errors', 'User is not removed ERROR');
        }
        return $response->withRedirect('/admin/users');
    }

    private function removeAvatar($fileName)
    {
        $file = $this->container->get('settings')['media']['uploaded'] . '/' . $fileName;

        if (file_exists($file)) {
            unlink($file);
            return true;
        }
        return false;
    }
}