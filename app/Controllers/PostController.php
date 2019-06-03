<?php

namespace App\Controllers;

use App\Services\PostServiceManager;
use App\Services\RubricServiceManager;
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

    public function add(Request $request, Response $response)
    {
        $messages = $this->container->get('flash')->getMessages();
        $sm = new RubricServiceManager($this->container);
        $rubrics = $sm->all();
        return $this->view->render($response, '/admin/posts/add.twig', ['rubrics' => $rubrics, 'messages' => $messages]);
    }

    public function store(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $rubric_ids = $data['rubric_id'];

        unset($data['rubric_id']);
        $sm = new PostServiceManager($this->container);

        if($insert_id = $sm->insert($data)){

            $sm->detachFromCategory($insert_id);

            foreach($rubric_ids as $rubric_id) {
                $sm->attachToCategory($rubric_id, $insert_id);
            }

            $this->container->get('flash')->addMessage('success', 'Post is successful added');
            return $response->withRedirect('/admin/posts');
        }
        $this->container->get('flash')->addMessage('errors', 'Post is not added');
        return $response->withRedirect('/admin/post/add');
    }

    public function edit(Request $request, Response $response)
    {
        $messages = $this->container->get('flash')->getMessages();
        $id = $request->getAttribute('id');

        $sm = new RubricServiceManager($this->container);
        $psm = new PostServiceManager($this->container);

        $rubrics = $sm->all();
        $post = $psm->find($id);

        return $this->view->render($response, '/admin/posts/edit.twig', ['post' => $post, 'rubrics' => $rubrics, 'messages' => $messages]);
    }

    public function update(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $rubric_ids = $data['rubric_id'];

        unset($data['rubric_id']);
        $sm = new PostServiceManager($this->container);

        if($sm->update($data)){
            $sm->detachFromCategory($data['id']);
            foreach($rubric_ids as $rubric_id) {
                $sm->attachToCategory($rubric_id, $data['id']);
            }
            $this->container->get('flash')->addMessage('success', 'Post is successful updated');
            return $response->withRedirect('/admin/post/edit/' . $data['id']);
        }
        $this->container->get('flash')->addMessage('errors', 'Post is not update ERROR');
        return $response->withRedirect('/admin/post/edit/' . $data['id']);
    }

    public function delete(Request $request, Response $response)
    {
        $id = $request->getAttribute('id');
        $sm = new PostServiceManager($this->container);
        if($sm->remove($id)) {
            $sm->detachFromCategory($id);
            $this->container->get('flash')->addMessage('success', 'Post is successful deleted');
            return $response->withRedirect('/admin/posts');
        }
        $this->container->get('flash')->addMessage('errors', 'Post is not deleted ERROR');
        return $response->withRedirect('/admin/posts');
    }
}