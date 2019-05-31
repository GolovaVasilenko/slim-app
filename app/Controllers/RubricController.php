<?php

namespace App\Controllers;


use App\Services\RubricServiceManager;
use Slim\Http\Request;
use Slim\Http\Response;

class RubricController extends AdminController
{

    public function index(Request $request, Response $response)
    {
        $messages = $this->container->get('flash')->getMessages();
        $sm = new RubricServiceManager($this->container);
        $rubrics = $sm->all();
        return $this->view->render($response, '/admin/rubrics/index.twig', ['rubrics' => $rubrics, 'messages' => $messages]);
    }

    public function add(Request $request, Response $response)
    {
        $messages = $this->container->get('flash')->getMessages();
        $sm = new RubricServiceManager($this->container);
        $rubrics = $sm->all();
        return $this->view->render($response, '/admin/rubrics/add.twig', ['rubrics' => $rubrics, 'messages' => $messages]);
    }

    public function store(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $sm = new RubricServiceManager($this->container);

        if($insert_id = $sm->insert($data)){
            $this->container->get('flash')->addMessage('success', 'Rubric is successful added');
            return $response->withRedirect('/admin/rubrics');
        }
        $this->container->get('flash')->addMessage('errors', 'Rubric is not added');
        return $response->withRedirect('/admin/add');
    }

    public function edit(Request $request, Response $response)
    {
        $messages = $this->container->get('flash')->getMessages();
        $id = $request->getAttribute('id');

        $sm = new RubricServiceManager($this->container);
        $rubric = $sm->find($id);

        return $this->view->render($response, '/admin/rubrics/add.twig', ['rubric' => $rubric, 'messages' => $messages]);
    }
}