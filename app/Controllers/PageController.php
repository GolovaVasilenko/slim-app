<?php

namespace App\Controllers;


use App\Services\PageServiceManager;
use Slim\Http\Request;
use Slim\Http\Response;

class PageController extends AbstractController
{
    public function index($request, $response, $args)
    {
        $sm = new PageServiceManager($this->container);

        $page = $sm->findByColumn('slug', 'home');
        $args['page'] = $page;

        return $this->view->render($response, 'pages/page.twig', $args);
    }

    public function show($request, $response)
    {
        $slug = trim($request->getRequestTarget(), "/");
        $sm = new PageServiceManager($this->container);
        $page = $sm->findByColumn('slug', $slug);
        $args['page'] = $page;

        return $this->view->render($response, 'pages/page.twig', $args);
    }

    public function pagesList($request, $response)
    {
        $messages = $this->container->get('flash')->getMessages();

        $sm = new PageServiceManager($this->container);

        $pages = $sm->all();

        return $this->view->render($response, 'admin/pages/index.twig', ['pages' => $pages, 'messages' => $messages]);
    }

    public function add(Request $request, Response $response)
    {
        $messages = $this->container->get('flash')->getMessages();

        return $this->view->render($response, 'admin/pages/add.twig', ['messages' => $messages]);
    }

    public function store(Request $request, Response $response)
    {
        $data = $request->getParsedBody();

        $sm = new PageServiceManager($this->container);

        if($insertId = $sm->insert($data)) {
            $this->container->get('flash')->addMessage('success', 'Page is successful added');
            return $response->withRedirect('/admin/pages');
        }

        $this->container->get('flash')->addMessage('errors', 'Page is not added ERROR');
        return $response->withRedirect('/admin/page/add');
    }

    public function edit(Request $request, Response $response)
    {
        $messages = $this->container->get('flash')->getMessages();
        $id = $request->getAttribute('id');
        $sm = new PageServiceManager($this->container);
        $page = $sm->find($id);
        return $this->view->render($response, 'admin/pages/edit.twig', ['page' => $page,'messages' => $messages]);
    }

    public function update(Request $request, Response $response)
    {
        $data = $request->getParsedBody();
        $sm = new PageServiceManager($this->container);
        $sm->update($data);

        $this->container->get('flash')->addMessage('success', 'Page is successful updated');
        return $response->withRedirect('/admin/page/edit/'. (int) $data['id']);
    }

    public function delete(Request $request, Response $response)
    {
        $id = $request->getAttribute('id');
        $sm = new PageServiceManager($this->container);
        $sm->remove($id);

        $this->container->get('flash')->addMessage('success', 'Page is successful deleted');
        return $response->withRedirect('/admin/pages');
    }
}