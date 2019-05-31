<?php

namespace App\Controllers;

use App\Services\PostServiceManager;
use Slim\Http\Request;
use Slim\Http\Response;

class PostController extends AdminController
{
    public function index(Request $request, Response $response)
    {
        $messages = $this->container->get('flash')->getMessages();
        $sm = new PostServiceManager($this->container);
        $posts = $sm->all();
        return $this->view->render($response, '/admin/posts/index.twig', ['posts' => $posts, 'messages' => $messages]);
    }
}