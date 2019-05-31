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
        $rubrics = $sm->all();
        $rubric = $sm->find($id);

        return $this->view->render($response, '/admin/rubrics/edit.twig', ['rubric' => $rubric, 'rubrics' => $rubrics, 'messages' => $messages]);
    }

    public function update(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $sm = new RubricServiceManager($this->container);

        if($sm->update($data)){
            $this->container->get('flash')->addMessage('success', 'Rubric is successful updated');
            return $response->withRedirect('/admin/rubric/edit/' . $data['id']);
        }
        $this->container->get('flash')->addMessage('errors', 'Rubric is not update ERROR');
        return $response->withRedirect('/admin/rubric/edit/' . $data['id']);
    }

    public function delete(Request $request, Response $response)
    {
        $id = $request->getAttribute('id');
        $sm = new RubricServiceManager($this->container);
        if($sm->remove($id)) {
            $this->container->get('flash')->addMessage('success', 'Rubric is successful deleted');
            return $response->withRedirect('/admin/rubrics');
        }
        $this->container->get('flash')->addMessage('errors', 'Rubric is not deleted ERROR');
        return $response->withRedirect('/admin/rubrics');
    }
}